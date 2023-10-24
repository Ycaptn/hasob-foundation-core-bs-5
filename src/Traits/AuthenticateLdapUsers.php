<?php

namespace Hasob\FoundationCore\Traits;

use Hasob\FoundationCore\Ldap\User as LdapUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use LdapRecord\Models\ActiveDirectory\Group;

trait AuthenticateLdapUsers{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirect = "dashboard";

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function credentials(Request $request)
    {
        return [
            'mail' => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $ldap_auth = Auth::attempt($this->credentials($request));
        // dd("heeee");
        if ($ldap_auth) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirect);
        }
        $base_dn = config('ldap.connections.default.base_dn');
        $ldap_database_uid = env('LDAP_DATABASE_UID');
      
        if (!$ldap_auth) {
            $user = \Hasob\FoundationCore\Models\User::where('email', $request->email)->first();

            if (!empty($user) && Hash::check($request->password, $user->password)) {
                $full_name = $user->last_name . ' ' . $user->first_name;
              
              
                $ldap_account = LdapUser::where('mail', '=', $request->email)->first();

                if (!$ldap_account) {
                    $salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 4)), 0, 4);
                    $encrypted_password = '{SSHA}' . base64_encode(sha1($request->password . $salt, true) . $salt);
                    //  $uid
                    $uid = $user->$ldap_database_uid;
                    
                    $ldap_user = new LdapUser();
                    $salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 4)), 0, 4);
                    $encrypted_password = '{SSHA}' . base64_encode(sha1($request->password . $salt, true) . $salt);
                    $ldap_user->setDn("uid=$uid,ou=people,$base_dn")->save([
                        "cn" => $user->first_name . ' ' . $user->last_name, // Concatenate first_name and last_name
                        "sn" => $user->last_name,
                        "givenname" => $user->first_name,
                        "mail" => $user->email,
                        "userPassword" => $encrypted_password, // Password generated above
                        "loginShell" => "/bin/bash",
                        "uidNumber" => time(), 
                        "gidNumber" => time(), 
                        "telephoneNumber" => $user->telephone,
                        "homeDirectory" => "/home/$user->first_name-$user->last_name",
                    ]); 
                 
                    $ldap_account = LdapUser::where('mail', '=', $request->email)->first();
                 
                    $user->guid = $ldap_account->getFirstAttribute('entryuuid');
                    $user->save();

                    
                 

                } else {
                 
                    $ldap_auth = Auth::attempt($this->credentials($request));
                }

                $ldap_auth = Auth::attempt($this->credentials($request));

                if ($ldap_auth) {
                    $request->session()->regenerate();
    
                    return redirect()->intended($this->redirect);
                }
            }

        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
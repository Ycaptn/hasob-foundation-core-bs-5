<?php

namespace Hasob\FoundationCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Hasob\FoundationCore\Events\UserCreatedEvent;
use Hasob\FoundationCore\Events\UserUpdatedEvent;
use Hasob\FoundationCore\Events\UserDeletedEvent;

use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\Ledgerable;
use Hasob\FoundationCore\Traits\Attachable;
use Hasob\FoundationCore\Traits\Commentable;
use Hasob\FoundationCore\Traits\Socialable;
use Hasob\FoundationCore\Traits\Taggable;
use Hasob\FoundationCore\Traits\Disable;
use Hasob\FoundationCore\Traits\Artifactable;
use Hasob\Scola\Core\Models\Staff;
use Hasob\Scola\Core\Models\Student;
use Hasob\Scola\ELearning\Models\Lecturer;
use Hasob\Scola\ELearning\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use Attachable;
    use Socialable;
    use Disable;
    use Artifactable;
    use GuidId;
    use Ledgerable;

    public $table = 'fc_users';

    protected $fillable = [
        'email', 'password','gender', 'telephone', 'first_name', 'middle_name', 'job_title', 'title', 'last_name', 'last_loggedin_at', 'department_id', 'organization_id','is_disabled','disable_reason','disabling_user_id','disabled_at'
    ];

    protected $hidden = [ 'password', 'remember_token', 'profile_image'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'last_loggedin_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $appends = ['full_name'];

    
    public function getFullNameAttribute(){
        return "{$this->title} {$this->last_name}, {$this->first_name} {$this->middle_name}";
    }
    
    public function department(){
        return $this->hasOne(Department::class,'id','department_id');
    }
    
    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function signature(){
        return $this->hasOne(Signature::class, 'owner_user_id', 'id');
    }
    
    public function department_manager(){
        if ($this->department_id != null){
            return User::role('manager')->where('department_id',$this->department_id)->first();
        }
        return null;
    }

    public static function all_users(Organization $org = null){

        $model = new User();
        $query = $model->newQuery();

        if ($org!=null){
            $query->where('organization_id', $org->id);
        }

        return $query->get();
    }

    public static function principal_user(Organization $org = null){

        $model = User::role('principal-officer');
        $query = $model->newQuery();

        if ($org!=null){
            $query->where('organization_id', $org->id);
        }

        return $query->first();
    }

    public function save(array $options = []){

        $exists = $this->exists;
        parent::save($options);

        if ($exists){
            UserUpdatedEvent::dispatch($this);
        } else {
            UserCreatedEvent::dispatch($this);
        }

    }

    public function delete(){
        parent::delete();
        UserDeletedEvent::dispatch($this);
    }

    public function getUserAccount($type = null)
    {
        $current_user = Auth()->user();

        if ($type === 'student') {
            return Student::where('user_id', $current_user->id)->first();
        }

        $staff = Staff::where('user_id', $current_user->id)->first();

        switch ($type) {
            case 'lecturer':
                return optional($staff)->lecturer;
            case 'manager':
                return optional($staff)->manager;
            default:
                return $staff;
        }
    }


}

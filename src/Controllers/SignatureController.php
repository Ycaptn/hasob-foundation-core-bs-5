<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\Signature;
use Hasob\FoundationCore\Models\User;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class SignatureController extends BaseController
{

    public function index(Organization $org)
    {
        $current_user = Auth()->user();

        $cdv_signatures = new \Hasob\FoundationCore\View\Components\CardDataView(Signature::class, "hasob-foundation-core::signatures.card_view_item");
        $cdv_signatures->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        // ->addDataOrder('user.ranking_ordinal','DESC')
                        // ->addModelJoin('fc_users', 'fc_signatures.owner_user_id', '=', 'fc_users.id')
                        // ->setQueryRelationship(['user' => []])
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(10)
                        ->setSearchPlaceholder('Search Signatures');

        if (request()->expectsJson()){
            return $cdv_signatures->render();
        }
        $users = User::where('department_id',"!=", null)->get();
        return view('hasob-foundation-core::signatures.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('all_users', $users)
                    ->with('cdv_signatures', $cdv_signatures);
    }

    public function create(Organization $org)
    {
        return view('hasob-foundation-core::signatures.create');
    }


    public function store(Organization $org, CreateSignatureRequest $request)
    {
        
        $input = $request->all();

        $file_extension = strtolower($request->file('signature_image')->extension());

        $allow_extension = ["jpeg","jpg"];

        if ($request->signature_image != null && $request->signature_image !="undefined"){ 
            $temp = file_get_contents($request->signature_image);
            $input->signature_image = base64_encode($temp); 
            array_merge($input,["signature_image" => $temp]);
        }
        dd(input);
        $signature = Signature::create($input);

        return redirect(route('fc.signatures.index'));
    }

    public function show(Organization $org, $id)
    {
        $signature = Signature::find($id);
        if (empty($signature)) {
            return redirect(route('fc.signatures.index'));
        }

        return view('hasob-foundation-core::signatures.show')->with('signature', $signature);
    }

    public function edit(Organization $org, $id)
    {
        $signature = Signature::find($id);
        if (empty($signature)) {
            return redirect(route('fc.signatures.index'));
        }

        return view('hasob-foundation-core::signatures.edit')->with('signature', $signature);
    }

    public function update(Organization $org, $id, UpdateSignatureRequest $request)
    {
        $signature = Signature::find($id);
        if (empty($signature)) {
            return redirect(route('fc.signatures.index'));
        }
        
        $input = $request->except('signature_image');

        if ($request->signature_image != null && $request->signature_image !="undefined"){ 
            $temp = file_get_contents($request->signature_image);
            array_merge($input, ["signature_image" => base64_encode($temp) ]) ; 
        }
        $signature->fill($input);
        $signature->save();

        return redirect(route('fc.signatures.index'));
    }

    public function destroy(Organization $org, $id)
    {
        $signature = Signature::find($id);
        if (empty($signature)) {
            return redirect(route('fc.signatures.index'));
        }

        $signature->delete();
        return redirect(route('fc.signatures.index'));
    }

    public function displayUserSignature(Organization $org, $id){

        $sign = Signature::find($id);
        if ($sign == null) {
            return "";
        }

        $content_type = (new \finfo(FILEINFO_MIME))->buffer(base64_decode($sign->signature_image));
        $response = response(trim(base64_decode($sign->signature_image)))->header('Content-Type', $content_type);

        ob_end_clean();
        return $response;
    }

     
}

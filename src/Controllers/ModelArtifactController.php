<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\ModelArtifact;

use Hasob\FoundationCore\Events\ModelArtifactCreated;
use Hasob\FoundationCore\Events\ModelArtifactUpdated;
use Hasob\FoundationCore\Events\ModelArtifactDeleted;

use Hasob\FoundationCore\Requests\CreateModelArtifactRequest;
use Hasob\FoundationCore\Requests\UpdateModelArtifactRequest;

use Hasob\FoundationCore\DataTables\ModelArtifactDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ModelArtifactController extends BaseController
{
    /**
     * Display a listing of the ModelArtifact.
     *
     * @param ModelArtifactDataTable $modelArtifactDataTable
     * @return Response
     */
    public function index(Organization $org, ModelArtifactDataTable $modelArtifactDataTable)
    {
        $current_user = Auth()->user();

        $cdv_model_artifacts = new \Hasob\FoundationCore\View\Components\CardDataView(ModelArtifact::class, "hasob-lab-manager-module::pages.model_artifacts.card_view_item");
        $cdv_model_artifacts->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search ModelArtifact');

        if (request()->expectsJson()){
            return $cdv_model_artifacts->render();
        }

        return view('hasob-lab-manager-module::pages.model_artifacts.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_model_artifacts', $cdv_model_artifacts);

        /*
        return $modelArtifactDataTable->render('hasob-lab-manager-module::pages.model_artifacts.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new ModelArtifact.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-lab-manager-module::pages.model_artifacts.create');
    }

    /**
     * Store a newly created ModelArtifact in storage.
     *
     * @param CreateModelArtifactRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateModelArtifactRequest $request)
    {
        $input = $request->all();

        /** @var ModelArtifact $modelArtifact */
        $modelArtifact = ModelArtifact::create($input);

        //Flash::success('Model Artifact saved successfully.');

        ModelArtifactCreated::dispatch($modelArtifact);
        return redirect(route('fc.modelArtifacts.index'));
    }

    /**
     * Display the specified ModelArtifact.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var ModelArtifact $modelArtifact */
        $modelArtifact = ModelArtifact::find($id);

        if (empty($modelArtifact)) {
            //Flash::error('Model Artifact not found');

            return redirect(route('fc.modelArtifacts.index'));
        }

        return view('hasob-lab-manager-module::pages.model_artifacts.show')->with('modelArtifact', $modelArtifact);
    }

    /**
     * Show the form for editing the specified ModelArtifact.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var ModelArtifact $modelArtifact */
        $modelArtifact = ModelArtifact::find($id);

        if (empty($modelArtifact)) {
            //Flash::error('Model Artifact not found');

            return redirect(route('fc.modelArtifacts.index'));
        }

        return view('hasob-lab-manager-module::pages.model_artifacts.edit')->with('modelArtifact', $modelArtifact);
    }

    /**
     * Update the specified ModelArtifact in storage.
     *
     * @param  int              $id
     * @param UpdateModelArtifactRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateModelArtifactRequest $request)
    {
        /** @var ModelArtifact $modelArtifact */
        $modelArtifact = ModelArtifact::find($id);

        if (empty($modelArtifact)) {
            //Flash::error('Model Artifact not found');

            return redirect(route('fc.modelArtifacts.index'));
        }

        $modelArtifact->fill($request->all());
        $modelArtifact->save();

        //Flash::success('Model Artifact updated successfully.');
        
        ModelArtifactUpdated::dispatch($modelArtifact);
        return redirect(route('fc.modelArtifacts.index'));
    }

    /**
     * Remove the specified ModelArtifact from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var ModelArtifact $modelArtifact */
        $modelArtifact = ModelArtifact::find($id);

        if (empty($modelArtifact)) {
            //Flash::error('Model Artifact not found');

            return redirect(route('fc.modelArtifacts.index'));
        }

        $modelArtifact->delete();

        //Flash::success('Model Artifact deleted successfully.');
        ModelArtifactDeleted::dispatch($modelArtifact);
        return redirect(route('fc.modelArtifacts.index'));
    }

        
    public function processBulkUpload(Organization $org, Request $request){

        $attachedFileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('uploads'), $attachedFileName);
        $path_to_file = public_path('uploads').'/'.$attachedFileName;

        //Process each line
        $loop = 1;
        $errors = [];
        $lines = file($path_to_file);

        if (count($lines) > 1) {
            foreach ($lines as $line) {
                
                if ($loop > 1) {
                    $data = explode(',', $line);
                    // if (count($invalids) > 0) {
                    //     array_push($errors, $invalids);
                    //     continue;
                    // }else{
                    //     //Check if line is valid
                    //     if (!$valid) {
                    //         $errors[] = $msg;
                    //     }
                    // }
                }
                $loop++;
            }
        }else{
            $errors[] = 'The uploaded csv file is empty';
        }
        
        if (count($errors) > 0) {
            return $this->sendError($this->array_flatten($errors), 'Errors processing file');
        }
        return $this->sendResponse($subject->toArray(), 'Bulk upload completed successfully');
    }
}

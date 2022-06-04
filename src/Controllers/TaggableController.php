<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\Taggable;

use Hasob\FoundationCore\Events\TaggableCreated;
use Hasob\FoundationCore\Events\TaggableUpdated;
use Hasob\FoundationCore\Events\TaggableDeleted;

use Hasob\FoundationCore\Requests\CreateTaggableRequest;
use Hasob\FoundationCore\Requests\UpdateTaggableRequest;

use Hasob\FoundationCore\DataTables\TaggableDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TaggableController extends BaseController
{
    /**
     * Display a listing of the Taggable.
     *
     * @param TaggableDataTable $taggableDataTable
     * @return Response
     */
    public function index(Organization $org, TaggableDataTable $taggableDataTable)
    {
        $current_user = Auth()->user();

        $cdv_taggables = new \Hasob\FoundationCore\View\Components\CardDataView(Taggable::class, "hasob-lab-manager-module::pages.taggables.card_view_item");
        $cdv_taggables->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search Taggable');

        if (request()->expectsJson()){
            return $cdv_taggables->render();
        }

        return view('hasob-lab-manager-module::pages.taggables.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_taggables', $cdv_taggables);

        /*
        return $taggableDataTable->render('hasob-lab-manager-module::pages.taggables.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new Taggable.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-lab-manager-module::pages.taggables.create');
    }

    /**
     * Store a newly created Taggable in storage.
     *
     * @param CreateTaggableRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateTaggableRequest $request)
    {
        $input = $request->all();

        /** @var Taggable $taggable */
        $taggable = Taggable::create($input);

        //Flash::success('Taggable saved successfully.');

        TaggableCreated::dispatch($taggable);
        return redirect(route('lm.taggables.index'));
    }

    /**
     * Display the specified Taggable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var Taggable $taggable */
        $taggable = Taggable::find($id);

        if (empty($taggable)) {
            //Flash::error('Taggable not found');

            return redirect(route('lm.taggables.index'));
        }

        return view('hasob-lab-manager-module::pages.taggables.show')->with('taggable', $taggable);
    }

    /**
     * Show the form for editing the specified Taggable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var Taggable $taggable */
        $taggable = Taggable::find($id);

        if (empty($taggable)) {
            //Flash::error('Taggable not found');

            return redirect(route('lm.taggables.index'));
        }

        return view('hasob-lab-manager-module::pages.taggables.edit')->with('taggable', $taggable);
    }

    /**
     * Update the specified Taggable in storage.
     *
     * @param  int              $id
     * @param UpdateTaggableRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateTaggableRequest $request)
    {
        /** @var Taggable $taggable */
        $taggable = Taggable::find($id);

        if (empty($taggable)) {
            //Flash::error('Taggable not found');

            return redirect(route('lm.taggables.index'));
        }

        $taggable->fill($request->all());
        $taggable->save();

        //Flash::success('Taggable updated successfully.');
        
        TaggableUpdated::dispatch($taggable);
        return redirect(route('lm.taggables.index'));
    }

    /**
     * Remove the specified Taggable from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var Taggable $taggable */
        $taggable = Taggable::find($id);

        if (empty($taggable)) {
            //Flash::error('Taggable not found');

            return redirect(route('lm.taggables.index'));
        }

        $taggable->delete();

        //Flash::success('Taggable deleted successfully.');
        TaggableDeleted::dispatch($taggable);
        return redirect(route('lm.taggables.index'));
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

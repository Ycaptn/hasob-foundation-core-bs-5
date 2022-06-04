<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\Tag;

use Hasob\FoundationCore\Events\TagCreated;
use Hasob\FoundationCore\Events\TagUpdated;
use Hasob\FoundationCore\Events\TagDeleted;

use Hasob\FoundationCore\Requests\CreateTagRequest;
use Hasob\FoundationCore\Requests\UpdateTagRequest;

use Hasob\FoundationCore\DataTables\TagDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TagController extends BaseController
{
    /**
     * Display a listing of the Tag.
     *
     * @param TagDataTable $tagDataTable
     * @return Response
     */
    public function index(Organization $org, TagDataTable $tagDataTable)
    {
        $current_user = Auth()->user();

        $cdv_tags = new \Hasob\FoundationCore\View\Components\CardDataView(Tag::class, "hasob-lab-manager-module::pages.tags.card_view_item");
        $cdv_tags->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search Tag');

        if (request()->expectsJson()){
            return $cdv_tags->render();
        }

        return view('hasob-lab-manager-module::pages.tags.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_tags', $cdv_tags);

        /*
        return $tagDataTable->render('hasob-lab-manager-module::pages.tags.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new Tag.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-lab-manager-module::pages.tags.create');
    }

    /**
     * Store a newly created Tag in storage.
     *
     * @param CreateTagRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateTagRequest $request)
    {
        $input = $request->all();

        /** @var Tag $tag */
        $tag = Tag::create($input);

        //Flash::success('Tag saved successfully.');

        TagCreated::dispatch($tag);
        return redirect(route('lm.tags.index'));
    }

    /**
     * Display the specified Tag.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            //Flash::error('Tag not found');

            return redirect(route('lm.tags.index'));
        }

        return view('hasob-lab-manager-module::pages.tags.show')->with('tag', $tag);
    }

    /**
     * Show the form for editing the specified Tag.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            //Flash::error('Tag not found');

            return redirect(route('lm.tags.index'));
        }

        return view('hasob-lab-manager-module::pages.tags.edit')->with('tag', $tag);
    }

    /**
     * Update the specified Tag in storage.
     *
     * @param  int              $id
     * @param UpdateTagRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateTagRequest $request)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            //Flash::error('Tag not found');

            return redirect(route('lm.tags.index'));
        }

        $tag->fill($request->all());
        $tag->save();

        //Flash::success('Tag updated successfully.');
        
        TagUpdated::dispatch($tag);
        return redirect(route('lm.tags.index'));
    }

    /**
     * Remove the specified Tag from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            //Flash::error('Tag not found');

            return redirect(route('lm.tags.index'));
        }

        $tag->delete();

        //Flash::success('Tag deleted successfully.');
        TagDeleted::dispatch($tag);
        return redirect(route('lm.tags.index'));
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

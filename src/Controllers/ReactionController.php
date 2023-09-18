<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\Reaction;

use Hasob\FoundationCore\Events\ReactionCreated;
use Hasob\FoundationCore\Events\ReactionUpdated;
use Hasob\FoundationCore\Events\ReactionDeleted;

use Hasob\FoundationCore\Requests\CreateReactionRequest;
use Hasob\FoundationCore\Requests\UpdateReactionRequest;

use Hasob\FoundationCore\DataTables\ReactionDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ReactionController extends BaseController
{
    /**
     * Display a listing of the Reaction.
     *
     * @param ReactionDataTable $reactionDataTable
     * @return Response
     */
    public function index(Organization $org, ReactionDataTable $reactionDataTable)
    {
        $current_user = Auth()->user();

        $cdv_reactions = new \Hasob\FoundationCore\View\Components\CardDataView(Reaction::class, "hasob-foundation-core::pages.reactions.card_view_item");
        $cdv_reactions->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search Reaction');

        if (request()->expectsJson()){
            return $cdv_reactions->render();
        }

        return view('hasob-foundation-core::pages.reactions.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_reactions', $cdv_reactions);

        /*
        return $reactionDataTable->render('hasob-foundation-core::pages.reactions.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new Reaction.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-foundation-core::pages.reactions.create');
    }

    /**
     * Store a newly created Reaction in storage.
     *
     * @param CreateReactionRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateReactionRequest $request)
    {
        $input = $request->all();

        /** @var Reaction $reaction */
        $reaction = Reaction::create($input);

        ReactionCreated::dispatch($reaction);
        return redirect(route('attendance.reactions.index'));
    }

    /**
     * Display the specified Reaction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        $current_user = Auth()->user();

        /** @var Reaction $reaction */
        $reaction = Reaction::find($id);

        if (empty($reaction)) {
            return redirect(route('attendance.reactions.index'));
        }

        return view('hasob-foundation-core::pages.reactions.show')
                            ->with('reaction', $reaction)
                            ->with('current_user', $current_user)
                            ->with('months_list', BaseController::monthsList())
                            ->with('states_list', BaseController::statesList());
    }

    /**
     * Show the form for editing the specified Reaction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        $current_user = Auth()->user();

        /** @var Reaction $reaction */
        $reaction = Reaction::find($id);

        if (empty($reaction)) {
            return redirect(route('attendance.reactions.index'));
        }

        return view('hasob-foundation-core::pages.reactions.edit')
                            ->with('reaction', $reaction)
                            ->with('current_user', $current_user)
                            ->with('months_list', BaseController::monthsList())
                            ->with('states_list', BaseController::statesList());
    }

    /**
     * Update the specified Reaction in storage.
     *
     * @param  int              $id
     * @param UpdateReactionRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateReactionRequest $request)
    {
        /** @var Reaction $reaction */
        $reaction = Reaction::find($id);

        if (empty($reaction)) {
            return redirect(route('attendance.reactions.index'));
        }

        $reaction->fill($request->all());
        $reaction->save();
        
        ReactionUpdated::dispatch($reaction);
        return redirect(route('attendance.reactions.index'));
    }

    /**
     * Remove the specified Reaction from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var Reaction $reaction */
        $reaction = Reaction::find($id);

        if (empty($reaction)) {
            return redirect(route('attendance.reactions.index'));
        }

        $reaction->delete();

        ReactionDeleted::dispatch($reaction);
        return redirect(route('attendance.reactions.index'));
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

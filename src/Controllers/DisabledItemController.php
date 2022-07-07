<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\DisabledItem;

use Hasob\FoundationCore\Events\DisabledItemCreated;
use Hasob\FoundationCore\Events\DisabledItemUpdated;
use Hasob\FoundationCore\Events\DisabledItemDeleted;

use Hasob\FoundationCore\Requests\CreateDisabledItemRequest;
use Hasob\FoundationCore\Requests\UpdateDisabledItemRequest;

use Hasob\FoundationCore\DataTables\DisabledItemDataTable;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;

use Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DisabledItemController extends BaseController
{
    /**
     * Display a listing of the DisabledItem.
     *
     * @param DisabledItemDataTable $disabledItemDataTable
     * @return Response
     */
    public function index(Organization $org, DisabledItemDataTable $disabledItemDataTable)
    {
        $current_user = Auth()->user();

        $cdv_disabled_items = new \Hasob\FoundationCore\View\Components\CardDataView(DisabledItem::class, "hasob-lab-manager-module::pages.disabled_items.card_view_item");
        $cdv_disabled_items->setDataQuery(['organization_id'=>$org->id])
                        //->addDataGroup('label','field','value')
                        //->setSearchFields(['field_to_search1','field_to_search2'])
                        //->addDataOrder('display_ordinal','DESC')
                        //->addDataOrder('id','DESC')
                        ->enableSearch(true)
                        ->enablePagination(true)
                        ->setPaginationLimit(20)
                        ->setSearchPlaceholder('Search DisabledItem');

        if (request()->expectsJson()){
            return $cdv_disabled_items->render();
        }

        return view('hasob-lab-manager-module::pages.disabled_items.card_view_index')
                    ->with('current_user', $current_user)
                    ->with('months_list', BaseController::monthsList())
                    ->with('states_list', BaseController::statesList())
                    ->with('cdv_disabled_items', $cdv_disabled_items);

        /*
        return $disabledItemDataTable->render('hasob-lab-manager-module::pages.disabled_items.index',[
            'current_user'=>$current_user,
            'months_list'=>BaseController::monthsList(),
            'states_list'=>BaseController::statesList()
        ]);
        */
    }

    /**
     * Show the form for creating a new DisabledItem.
     *
     * @return Response
     */
    public function create(Organization $org)
    {
        return view('hasob-lab-manager-module::pages.disabled_items.create');
    }

    /**
     * Store a newly created DisabledItem in storage.
     *
     * @param CreateDisabledItemRequest $request
     *
     * @return Response
     */
    public function store(Organization $org, CreateDisabledItemRequest $request)
    {
        $input = $request->all();

        /** @var DisabledItem $disabledItem */
        $disabledItem = DisabledItem::create($input);

        //Flash::success('Disabled Item saved successfully.');

        DisabledItemCreated::dispatch($disabledItem);
        return redirect(route('fc.disabledItems.index'));
    }

    /**
     * Display the specified DisabledItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Organization $org, $id)
    {
        /** @var DisabledItem $disabledItem */
        $disabledItem = DisabledItem::find($id);

        if (empty($disabledItem)) {
            //Flash::error('Disabled Item not found');

            return redirect(route('fc.disabledItems.index'));
        }

        return view('hasob-lab-manager-module::pages.disabled_items.show')->with('disabledItem', $disabledItem);
    }

    /**
     * Show the form for editing the specified DisabledItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Organization $org, $id)
    {
        /** @var DisabledItem $disabledItem */
        $disabledItem = DisabledItem::find($id);

        if (empty($disabledItem)) {
            //Flash::error('Disabled Item not found');

            return redirect(route('fc.disabledItems.index'));
        }

        return view('hasob-lab-manager-module::pages.disabled_items.edit')->with('disabledItem', $disabledItem);
    }

    /**
     * Update the specified DisabledItem in storage.
     *
     * @param  int              $id
     * @param UpdateDisabledItemRequest $request
     *
     * @return Response
     */
    public function update(Organization $org, $id, UpdateDisabledItemRequest $request)
    {
        /** @var DisabledItem $disabledItem */
        $disabledItem = DisabledItem::find($id);

        if (empty($disabledItem)) {
            //Flash::error('Disabled Item not found');

            return redirect(route('fc.disabledItems.index'));
        }

        $disabledItem->fill($request->all());
        $disabledItem->save();

        //Flash::success('Disabled Item updated successfully.');
        
        DisabledItemUpdated::dispatch($disabledItem);
        return redirect(route('fc.disabledItems.index'));
    }

    /**
     * Remove the specified DisabledItem from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Organization $org, $id)
    {
        /** @var DisabledItem $disabledItem */
        $disabledItem = DisabledItem::find($id);

        if (empty($disabledItem)) {
            //Flash::error('Disabled Item not found');

            return redirect(route('fc.disabledItems.index'));
        }

        $disabledItem->delete();

        //Flash::success('Disabled Item deleted successfully.');
        DisabledItemDeleted::dispatch($disabledItem);
        return redirect(route('fc.disabledItems.index'));
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

<?php
namespace Hasob\Workflow\Interfaces;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;


interface IMessageable
{

    public function get_message_name();
    public function get_message_destinations();

    public function get_message_destination($type);
    public function get_message_destination_types();

}

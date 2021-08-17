
<a href="#" data-val='{{$id}}' class='btnEditRole'>
    {!! Form::button('<i class="fa fa-edit"></i>', ['type'=>'button']) !!}
</a>

<a href="#" data-val='{{$id}}' class='btn-delete-mdl-enrollment-modal'>
    {!! Form::button('<i class="fa fa-trash"></i>', ['type'=>'button', 'onclick' => "return confirm('Are you sure?')"]) !!}
</a>
{{-- <a href="#" data-val='{{$id}}' class='btn-show-mdl-support-modal'>
        {!! Form::button('<i class="fa fa-eye"></i>', ['type'=>'button']) !!}
    </a>
    
    <a href="#" data-val='{{$id}}' class='btn-edit-mdl-support-modal'>
        {!! Form::button('<i class="fa fa-edit"></i>', ['type'=>'button']) !!}
    </a>
    
    <a href="#" data-val='{{$id}}' class='btn-delete-mdl-support-modal'>
        {!! Form::button('<i class="fa fa-trash"></i>', ['type'=>'button']) !!}
    </a> --}}

<a data-toggle="tooltip" title="View" data-val='{{ $id }}' class="btn-show-mdl-support-modal inline-block me-2"
    href="#">
    <i class="zmdi zmdi-eye txt-primary" style="opacity:80%"></i>
</a>

<a data-toggle="tooltip" title="Edit" data-val='{{ $id }}' class="btn-edit-mdl-support-modal inline-block me-2"
    href="#">
    <i class="zmdi zmdi-border-color txt-warning" style="opacity:80%"></i>
</a>

<a data-toggle="tooltip" title="Delete" data-val='{{ $id }}'
    class="btn-delete-mdl-support-modal inline-block me-2" href="#">
    <i class="zmdi zmdi-delete txt-danger" style="opacity:80%"></i>
</a>

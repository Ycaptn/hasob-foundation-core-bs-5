<div class="row">
    <div class="col-lg-2">
        <a href="{{ route('fc.departments.show',$department->id) }}">
            @if ( $department->logo_image != null )
                <img class="img-circle" src="../imgs/logo.png" />
            @else
                <i class="fa fa-4x fa-globe"></i>
            @endif
        </a>
    </div>
    <div class="col-lg-10">

        <span class="panel-title txt-dark">
            <a href="{{ route('fc.departments.show',$department->id) }}">{{ $department->long_name }}</a>
        </span>

        <a href="#" class="pull-right">
            <i class="fa fa-edit font-15 pr-3 text-primary btn-edit-mdl-department-modal" data-val="{{$department->id}}" data-toggle="tooltip" title="" data-original-title="Edit"></i>
            <i class="fa fa-trash font-15 pr-3 text-danger btn-delete-mdl-department-modal"  data-val="{{$department->id}}" data-toggle="tooltip" title="" data-original-title="Delete"></i>
        </a>

        <br/>

        <p class="small">{!! $department->physical_location !!} </p>
        <p class="small">{!! $department->telephone !!} | {!! $department->email !!}</p>
    </div>
</div>
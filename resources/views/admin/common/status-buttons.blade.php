@if ($status == "active")
    <div class="btn-group-horizontal" id="assign_remove_{{$id}}">
        {!! Form::button('<span class="ladda-label">Active</span>', [
            'class' => 'btn btn-success assign_unassign ladda-button',
            'id' => 'remove',
            'data-style' => 'slide-left',
            'data-url' => route('common.changestatus'),
            'data-id' => $id,
            'type' => 'button',
            'data-type' => 'unassign',
            'data-table_name' => $table_name,
            'style' => "height:28px; padding:0 12px"
        ]) !!}
    </div>
    <div class="btn-group-horizontal" id="assign_add_{{$id}}" style="display: none">
        {!! Form::button('<span class="ladda-label">In Active</span>', [
            'class' => 'btn btn-danger assign_unassign ladda-button',
            'data-style' => 'slide-left',
            'data-id' => $id,
            'data-url' => route('common.changestatus'),
            'type' => 'button',
            'data-type' => 'assign',
            'data-table_name' => $table_name,
            'style' => "height:28px; padding:0 12px"
        ]) !!}
    </div>
@else
    <div class="btn-group-horizontal" id="assign_add_{{$id}}">
        {!! Form::button('<span class="ladda-label">In Active</span>', [
            'class' => 'btn btn-danger assign_unassign ladda-button',
            'data-style' => 'slide-left',
            'data-id' => $id,
            'data-url' => route('common.changestatus'),
            'type' => 'button',
            'data-type' => 'assign',
            'data-table_name' => $table_name,
            'style' => "height:28px; padding:0 12px"
        ]) !!}
    </div>
    <div class="btn-group-horizontal" id="assign_remove_{{$id}}" style="display: none">
        {!! Form::button('<span class="ladda-label">Active</span>', [
            'class' => 'btn btn-success assign_unassign ladda-button',
            'id' => 'remove',
            'data-id' => $id,
            'data-style' => 'slide-left',
            'data-url' => route('common.changestatus'),
            'type' => 'button',
            'data-type' => 'unassign',
            'data-table_name' => $table_name,
            'style' => "height:28px; padding:0 12px"
        ]) !!}
    </div>
@endif

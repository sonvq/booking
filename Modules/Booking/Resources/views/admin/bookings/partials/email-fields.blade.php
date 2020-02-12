@php
$type = [
    '' => trans('email::emails.table.type_choices.empty_option'),
    'booking' => trans('email::emails.table.type_choices.booking'),
];

$status = [
    '' => trans('email::emails.table.status_choices.empty_option'),
    'draft' => trans('email::emails.table.status_choices.draft'),
    'publish' => trans('email::emails.table.status_choices.publish'),
];
@endphp
<div class="box-body">
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                {!! Form::label('type',  trans('email::emails.table.type')) !!}
                {!! Form::text("type", $type[$email->type], ['class' => 'form-control', 'readonly' => true]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class='form-group'>
                {!! Form::label("subject", trans('email::emails.table.subject')) !!}
                {!! Form::text("subject", $newSubject, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class='form-group'>
                {!! Form::label("content", trans('email::emails.table.content')) !!}
                {!! Form::textarea("content", $newContent, ['id' => 'contentEmail', 'class' => 'form-control', 'readonly' => true]) !!}
            </div>
        </div>
    </div>
</div>

@push('js-stack')
    <script>
        // Replace the <textarea id="contentEmail"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('contentEmail');
    </script>
@endpush
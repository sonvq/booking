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
            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                {!! Form::label('type',  trans('email::emails.table.type'), array('class' => 'required')) !!}
                {!! Form::select('type', $type, old("type"), ['class' => 'selectize-single']) !!}
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class='form-group{{ $errors->has("subject") ? ' has-error' : '' }}'>
                {!! Form::label("subject", trans('email::emails.table.subject'), array('class' => 'required')) !!}
                {!! Form::text("subject",old("subject"), ['class' => 'form-control', 'data-slug' => 'source']) !!}
                {!! $errors->first("subject", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class='form-group{{ $errors->has("content") ? ' has-error' : '' }}'>
                {!! Form::label("content", trans('email::emails.table.content'), array('class' => 'required')) !!}
                {!! Form::textarea("content",old("content"), ['id' => 'contentEmail', 'class' => '', 'data-slug' => 'source']) !!}
                {!! $errors->first("content", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                {!! Form::label('status',  trans('email::emails.table.status'), array('class' => 'required')) !!}
                {!! Form::select('status', $status, old("status"), ['class' => 'selectize-single']) !!}
                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class='form-group'>
                <p class="help-block text-blue">*Các trường có thể dùng trong tiêu đề và nội dung là:</p>
                <ul>
                    <li>
                        [booking_number]
                    </li>
                    <li>
                        [customer_name]
                    </li>
                    <li>
                        [checkin_date]
                    </li>
                    <li>
                        [checkout_date]
                    </li>
                    <li>
                        [room_info]
                    </li>
                    <li>
                        [hotel_name]
                    </li>
                    <li>
                        [campaign_name]
                    </li>
                    <li>
                        [customer_info]
                    </li>
                    <li>
                        [service_info]
                    </li>
                    <li>
                        [surcharge_info]
                    </li>
                </ul>
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

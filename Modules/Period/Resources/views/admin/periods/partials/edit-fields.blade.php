<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('hotel_id') ? 'has-error' : '' }}">
                {!! Form::label('hotel_id', trans('period::periods.form.hotel_id'), array('class' => 'required')) !!}
                {!! Form::select('hotel_id[]', $hotels, $period->hotels()->allRelatedIds(), ['class' => 'selectize-hotel', 'multiple' => 'multiple']) !!}
                {!! $errors->first('hotel_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
                {!! Form::label('country_id', trans('period::periods.form.country_id')) !!}
                {!! Form::select('country_id[]', $countries, $period->countries()->allRelatedIds(), ['class' => 'selectize-multiple', 'multiple' => 'multiple']) !!}
                {!! $errors->first('country_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('period::periods.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', $period->name, ['class' => 'form-control', 'placeholder' => trans('period::periods.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('cod') ? ' has-error' : '' }}">
                {!! Form::label('cod', trans('period::periods.form.cod'), array('class' => 'required')) !!}
                {!! Form::text('cod', $period->cod, ['class' => 'form-control', 'placeholder' => trans('period::periods.form.cod')]) !!}
                {!! $errors->first('cod', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('campaign_id') ? 'has-error' : '' }}">
                {!! Form::label('campaign_id', trans('period::periods.form.campaign_id'), array('class' => 'required')) !!}
                {!! Form::select('campaign_id', [], old('campaign_id') , ['class' => 'selectize-campaign']) !!}
                {!! $errors->first('campaign_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="date-range-container">
        <div class="row">
            <div class="col-md-12">
                <h4>{{  trans('period::periods.form.date_range') }}</h4>
            </div>
        </div>

        <div class="row">
            @if ($errors->has('date_range'))
                <div class="col-md-12">
                    <div class="form-group has-error">
                        {!! $errors->first('date_range', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            @endif
            @if ($errors->has('start_date') || $errors->has('end_date'))
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                        {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                        {!! $errors->first('end_date', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            @endif
        </div>

        @php
            $periodDates = $period->dates()->get()->toArray();
            $firstPeriodDateRange = $period->dates()->first();
            $firstStartDate = \DateTime::createFromFormat('Y-m-d', $firstPeriodDateRange->start_date)->format('d/m/Y');
            $firstEndDate = \DateTime::createFromFormat('Y-m-d', $firstPeriodDateRange->end_date)->format('d/m/Y');
        @endphp
        <div class="row">
            <div class="col-md-4">
                <div class="form-group{{ ($errors->has('start_date') || $errors->has('date_range')) ? ' has-error' : '' }}">
                    {!! Form::label('start_date', trans('period::periods.form.start_date'), array('class' => 'required')) !!}
                    {!! Form::text('start_date[]', $firstStartDate, ['class' => 'form-control datepicker', 'placeholder' => trans('period::periods.form.start_date')]) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ ($errors->has('end_date') || $errors->has('date_range')) ? ' has-error' : '' }}">
                    {!! Form::label('end_date', trans('period::periods.form.end_date'), array('class' => 'required')) !!}
                    {!! Form::text('end_date[]', $firstEndDate, ['class' => 'form-control datepicker', 'placeholder' => trans('period::periods.form.end_date')]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="add-new-date-row add-new-row">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

        @if(count($periodDates) > 1 && empty(old('start_date')))
            @foreach ($periodDates as $key => $periodDate)
                @if ($key !== 0)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ ($errors->has('start_date') || $errors->has('date_range')) ? ' has-error' : '' }}">
                                <input value="{{ \DateTime::createFromFormat('Y-m-d', $periodDate['start_date'])->format('d/m/Y') }}" class="form-control datepicker" placeholder="{{ trans('period::periods.form.start_date') }}" name="start_date[]" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ ($errors->has('end_date') || $errors->has('date_range')) ? ' has-error' : '' }}">
                                <input value="{{ \DateTime::createFromFormat('Y-m-d', $periodDate['end_date'])->format('d/m/Y') }}" class="form-control datepicker" placeholder="{{ trans('period::periods.form.end_date') }}" name="end_date[]" type="text">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="remove-row" href="javascript:;" onclick="remove_date_row(this);">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        @if(!empty(old('start_date')) && count(old('start_date')) > 1)
            @foreach (old('start_date') as $key => $value)
                @if ($key !== 0)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ ($errors->has('start_date') || $errors->has('date_range')) ? ' has-error' : '' }}">
                                <input value="{{ old("start_date.$key") }}" class="form-control datepicker" placeholder="{{ trans('period::periods.form.start_date') }}" name="start_date[]" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ ($errors->has('end_date') || $errors->has('date_range')) ? ' has-error' : '' }}">
                                <input value="{{ old("end_date.$key") }}" class="form-control datepicker" placeholder="{{ trans('period::periods.form.end_date') }}" name="end_date[]" type="text">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="remove-row" href="javascript:;" onclick="remove_date_row(this);">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

@include('period::admin.periods.partials.javascript', ['editMode' => true])


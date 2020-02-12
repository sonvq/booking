<div class="tab-pane" id="tab_2-2">
    @if (count($emails) > 0)
        <div class="table-responsive">
            <table class="data-table table table-bordered table-hover">
                <tr>
                    <th>
                        {{ trans('booking::bookings.email.title.date') }}
                    </th>
                    <th>
                        {{ trans('booking::bookings.email.title.from-to') }}
                    </th>
                    <th>
                        {{ trans('booking::bookings.email.title.subject') }}
                    </th>
                    <th>
                        {{ trans('booking::bookings.email.title.body') }}
                    </th>
                </tr>

                @foreach($emails as $email)
                    <tr>
                        <td>
                            @php echo $email->getDate()->format('d/m/Y H:i:s'); @endphp
                        </td>
                        <td>
                            {{ trans('booking::bookings.email.title.from') }}:
                            @if (count($email->getFrom()) > 0)
                                <ul>
                                    @foreach ($email->getFrom() as $from)
                                        <li>@php echo $from->personal . ' (' . $from->mail . ')'; @endphp</li>
                                    @endforeach
                                </ul>
                            @endif

                            {{ trans('booking::bookings.email.title.to') }}:
                            @if (count($email->getTo()) > 0)
                                <ul>
                                    @foreach ($email->getTo() as $to)
                                        <li>@php echo $to->personal . ' (' . $to->mail . ')'; @endphp</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        @php
                            $subjectEncoded = $email->getHeaderInfo()->subject;
                            $subjectDecoded = imap_mime_header_decode($subjectEncoded);
                            $subject = '';
                            if (count($subjectDecoded) > 0) {
                                foreach($subjectDecoded as $element) {
                                    $subject .= $element->text;
                                }
                            }
                        @endphp
                        <td>
                            @php echo $subject; @endphp
                        </td>
                        <td>
                            @php echo $email->getHTMLBody(true); @endphp
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-danger">
                        {{ trans('booking::bookings.messages.no_email_related_this_booking') }}
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
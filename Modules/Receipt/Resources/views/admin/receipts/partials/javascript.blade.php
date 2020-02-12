<script>

    /**
     * Binding event for elements
     */
    function bindEventForElements() {
        console.log('bindEventForElements');
        $('select.selectize-payment-type').on('change', function(){
            console.log('select.selectize-payment-type change');
            if($(this).val() === 'deduct') {
                $('.parent_id_container').removeClass('hidden');
            } else {
                $('.parent_id_container').addClass('hidden');
            }
        });
    }


    $(document).ready(function() {
        setTimeout(function(){
            bindEventForElements();

            @if(!$editMode)
                $('select.selectize-status')[0].selectize.setValue('{{\Modules\Receipt\Entities\Receipt::STATUS_PENDING}}');
                $('select.selectize-status')[0].selectize.lock();
            @else
                @if($canChangeStatus && $user->id != $receipt->author_id && $receipt->status === \Modules\Receipt\Entities\Receipt::STATUS_PENDING)
                    $('select.selectize-status')[0].selectize.unlock();
                @else
                    $('select.selectize-status')[0].selectize.lock();
                @endif

                @if($receipt->status === \Modules\Receipt\Entities\Receipt::STATUS_CONFIRMED)
                    if (typeof($('select.selectize-status')[0]) !== 'undefined') {
                        $('select.selectize-status')[0].selectize.lock();
                    }

                    if (typeof($('select.selectize-type')[0]) !== 'undefined') {
                        $('select.selectize-type')[0].selectize.lock();
                    }

                    if (typeof($('select.selectize-payment-type')[0]) !== 'undefined') {
                        $('select.selectize-payment-type')[0].selectize.lock();
                    }

                    $('#amount').prop('readonly', true);

                    if (typeof($('select.selectize-parent-id')[0]) !== 'undefined') {
                        $('select.selectize-parent-id')[0].selectize.lock();
                    }

                    $('#start_date').prop('readonly', true)
                    $("#start_date").datepicker('remove');
                @endif
            @endif

            if($('select.selectize-payment-type').val() === 'deduct') {
                $('.parent_id_container').removeClass('hidden');
            } else {
                $('.parent_id_container').addClass('hidden');
            }
        });
    });
</script>

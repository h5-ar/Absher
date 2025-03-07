@props([
    'name' => '',
    'addButton' => 'Add New',
])

<div id="repeater-list" data-repeater-list="{{ $name }}">
    {{ $slot }}
    <div class="row">
        <div class="col-12 mb-1 d-flex">
            <button class="btn btn-icon fs-5 fw-bolder" type="button" id="repeater-create"
                style="background-color:var(--nav-item-sub-selected-background);color:whitesmoke;">
                <i data-feather="plus" class="me-25"></i>
                <span>{{ translate('Add New') }}</span>
            </button>
        </div>
    </div>
</div>


@push('layout-scripts')
    <script>
        $(document).ready(function() {
            var repeater_name = '{{ $name }}';
            var orginalCopy = $($('.items-list-clone')[0]).clone(true);
            $.each($('.items-list-clone').find('[required]'), function(indexInArray, valueOfElement) {
                $(valueOfElement).removeAttr('required');
            });
            var items_list_repeater = $('.items-list');
            var repeater = $(`[data-repeater-list="${repeater_name}"]`);
            items_list_repeater = $('.items-list');
            handelInputs(items_list_repeater, repeater_name);
        });

        $("#repeater-create").click(function(e) {
            e.preventDefault();
            var repeater_name = '{{ $name }}';
            var repeater = $(`[data-repeater-list="${repeater_name}"]`);
            var elements = $('.items-list');
            const clone = $($('.items-list-clone').clone(true)[0])
                .css('display', 'none')
                .addClass('items-list')
                .removeClass('items-list-clone')
                .removeAttr('id');

            $('#repeater-create').parent().before(clone);
            elements = $('.items-list');
            handelInputs(elements, repeater_name);
            clone.slideDown(300);
        });


        function handelInputs(listItems, repeaterName) {
            $.each(listItems, function(listIndex, list) {
                $.each($(list).find('[name]'), function(indexInArray, input) {
                    input.name = `${repeaterName}[${listIndex}][${$(input).data('orginal-name')}]`;
                    input.id = `${$(input).data('orginal-id')}${listIndex}`;
                });
            });
            if ($('.items-list img').length > 0) {
                $.each($('.items-list img'), function(indexInArray, image) {
                    var inputInParent = $(image).parent().parent().find('input')[0];
                    if (inputInParent) {
                        image.id = `show${inputInParent.id}`;
                    }
                });
            }
        }

        function makeInputsEmpty(contianer) {
            $.each($(contianer).find('input'), function(indexInArray, valueOfElement) {
                valueOfElement.value = '';
            });

            $.each($(contianer).find('img'), function(indexInArray, valueOfElement) {
                @if (app()->getLocale() == 'ar')
                    $(valueOfElement).attr('src',
                        '{{ asset('app-assets/images/clickToAddAr.png') }}'
                    );
                @else
                    $(valueOfElement).attr('src',
                        '{{ asset('app-assets/images/clickToAddEn.png') }}'
                    );
                @endif

            });
        }

        function deleteItem(element) {
            var parent = $(element).parent().parent()[0];
            $(parent).slideToggle(300, function() {
                $(parent).remove();
            });
        }
    </script>
@endpush

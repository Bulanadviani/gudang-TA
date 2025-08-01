@props([
    'id'=>'select-merk',
    'name' => 'merk',
    'placeholder' => 'Pilih Merk',
    'url' => '/pengaturan/merk',
    'selectId' => 'id',
    'onchange' => null,
    'selected' => null,
])

<select id="{{ $id }}" style="width:100%" name="{{ $name }}" {{ $attributes }}>
    {{$slot}}
</select>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectElement = $('#{{ $id }}');

        $('#{{ $id }}').select2({
            dropdownParent: $('#{{ $id }}').parent(),
            placeholder: "{{ $placeholder }}",
            ajax: {
                url: "{{ $url }}", 
                dataType: "json",
                data: (params) => {
                    return {
                        keyword: params.term,
                        page: params.page || 1,
                    };
                },
                processResults: (data) => {
                    // data.data.unshift({name:'All Country',code:'', value=""});
                    return {
                        results: data.data.map((merk) => {
                            return { text: `${merk.nama}`, id:  merk["{{ $selectId }}"] }; // Use `merk.id`
                        }),
                        pagination: {
                             more:  data.current_page < data.last_page,
                        },
                    };
                },
            },
            templateSelection: function (data) {
                if (!data.id) {
                    return data.text;
                }

                // Create a custom element for the selected item
                const container = document.createElement('span');
                container.textContent = data.text;

                // Add the "X" button
                const clearButton = document.createElement('button');
                clearButton.type = 'button';
                clearButton.textContent = '×';
                clearButton.style.cssText = 'border: none; background: none; color: red; font-size: 16px; margin-left: 8px; cursor: pointer;';
                
                // Add event listener to clear the selection
                clearButton.addEventListener('click', (e) => {
                    e.stopPropagation(); // Prevent dropdown from opening
                    selectElement.val(null).trigger('change');
                });

                container.appendChild(clearButton);
                return container;
            },
            escapeMarkup: function (markup) {
                return markup; // Allow custom HTML
            }
        });

        @if ($onchange)
            selectElement.on('change', {!! $onchange !!});
        @endif
        
        @if ($selected)
            $.ajax({
                url: "{{ $url }}",
                data: {
                    keyword: '',
                    id: "{{ $selected }}" 
                },
                success: function (data) {
                    const selectedData = data.data.find(item => item.id == "{{ $selected }}");
                    if (selectedData) {
                        const option = new Option(selectedData.nama, selectedData.id, true, true);
                        selectElement.append(option).trigger('change');
                    }
                }
            });
        @endif
    });
</script>

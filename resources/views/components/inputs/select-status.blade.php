@props([
    'id'=>'select-status',
    'name' => 'status',
    'placeholder' => 'Pilih status',
    'url' => '/pengaturan/status',
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

        selectElement.select2({
            dropdownParent: selectElement.parent(),
            placeholder: "{{ $placeholder }}",
            ajax: {
                url: "{{ $url }}",
                dataType: "json",
                data: (params) => ({
                    keyword: params.term,
                    page: params.page || 1,
                }),
                processResults: (data) => ({
                    results: data.data.map((status) => ({
                        text: `[${status.jenis}] ${status.nama}`,
                        id: status["{{ $selectId }}"],
                        jenis:status.jenis,
                    })),
                    pagination: {
                        more: data.current_page < data.last_page,
                    },
                }),
            },
            templateSelection: function (data) {
                if (!data.id) return data.text;
                const container = document.createElement('span');
                container.textContent = data.text;

                const clearButton = document.createElement('button');
                clearButton.type = 'button';
                clearButton.textContent = '×';
                clearButton.style.cssText = 'border: none; background: none; color: red; font-size: 16px; margin-left: 8px; cursor: pointer;';
                
                clearButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    selectElement.val(null).trigger('change');
                });

                container.appendChild(clearButton);
                return container;
            },
            escapeMarkup: function (markup) {
                return markup;
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
                        const text = `[${selectedData.jenis}] ${selectedData.nama}`;
                        const option = new Option(text, selectedData.id, true, true);
                        $(option).data('data', {
                            id: selectedData.id,
                            text: text,
                            jenis: selectedData.jenis
                        });
                        selectElement.append(option).trigger('change');
                    }
                }
            });
        @endif
    });
</script>


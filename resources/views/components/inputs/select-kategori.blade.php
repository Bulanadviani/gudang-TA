@props([
    'id' => 'select-kategori',
    'name' => 'kategori',
    'placeholder' => 'Pilih Kategori',
    'url' => '/pengaturan/kategori',
    'selectId' => 'id',
    'onchange' => null,
    'selected' => null,
])

<select id="{{ $id }}" style="width:100%" name="{{ $name }}" {{ $attributes }}>
    {{ $slot }}
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
                data: params => ({
                    keyword: params.term,
                    page: params.page || 1,
                }),
                processResults: data => ({
                    results: data.data.map(item => ({
                        id: item["{{ $selectId }}"],
                        text: item.nama
                    })),
                    pagination: {
                        more: data.current_page < data.last_page
                    }
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
            escapeMarkup: markup => markup,
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

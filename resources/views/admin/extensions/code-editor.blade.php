<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <textarea class="{{ $class }}"   {!! $attributes !!} >{!! $value !!}</textarea>

        <input type="hidden" name="{{$name}}" value="{{ old($column, $value) }}" />

        @include('admin::form.help-block')
    </div>
</div>

<script require="@code-editor" init="{!! $selector !!}">
    var Editor = CodeMirror.fromTextArea(document.getElementById(id), {
        lineNumbers: true,
        mode:"css",
        theme: "duotone-light",
        extraKeys: {
            "Tab": function(cm){
                cm.replaceSelection("    " , "end");
            },
        }
    });
    Editor.on("change", function (Editor, changes) {
        let val = Editor.getValue();
        $this.parents('.form-field').find('input[name="{{$name}}"]').val(val);
    });
</script>

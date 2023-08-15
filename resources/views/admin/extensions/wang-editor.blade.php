<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div {!! $attributes !!} style="width: 100%; height: 100%;">
            {{--<p>{!! $value !!}</p>--}}
            <div class="editor—wrapper">
                <div class="toolbar-container"><!-- 工具栏 --></div>
                <div class="editor-container"><!-- 编辑器 --></div>
            </div>
            @include('admin::form.help-block')
        </div>
        <input type="hidden" name="{{$name}}" value="{{ old($column, $value) }}" />



    </div>
</div>
<style>
    .editor—wrapper {
        border: 1px solid #dbe3e6!important;
        z-index: 100; /* 按需定义 */

    }
    .toolbar-container { border-bottom: 1px solid #dbe3e6!important; }
    .editor-container { height: 500px; }
</style>
<!-- script标签加上 "init" 属性后会自动使用 Dcat.init() 方法动态监听元素生成 -->
<script require="@wang-editor" init="{!! $selector !!}">

    const { createEditor, createToolbar } = window.wangEditor

    const editorConfig = {

        placeholder: '请输入内容...',
        MENU_CONF: {
            uploadImage: {
                server:'{{ admin_url('upload/wang-editor/image') }}',
                fieldName: 'file',
                meta: {
                    _token: '{{ csrf_token() }}',
                },
            }

        },
        onChange(editor) {
            const html = editor.getHtml()
            $this.parents('.form-field').find('input[type="hidden"]').val(html);
            // 也可以同步到 <textarea>
        },

    }



    const editor = createEditor({
        selector: '#'+id+' .editor-container',
        html: $this.parents('.form-field').find('input[type="hidden"]').val(),
        config: editorConfig,
        mode: "{{ $options['mode'] }}", // or 'simple'
    })




    const toolbarConfig = {}

    const toolbar = createToolbar({
        editor,
        selector: '#'+id+' .toolbar-container',
        config: toolbarConfig,
        mode: '{{ $options['mode'] }}', // or 'simple'
    })

/*    var E = window.wangEditor

    var editor = new E('#' + id);
    editor.config.zIndex = 0
    editor.config.uploadImgShowBase64 = true
    editor.config.onchange = function (html) {
        $this.parents('.form-field').find('input[type="hidden"]').val(html);
    }
    editor.config.showFullScreen = false
    editor.config.colors = [
        '#000000',
        '#FFFFFF',
        '#eeece0',
        '#1c487f',
        '#4d80bf',
        '#F7F2FF',
        '#814F04',
        '#EAFCFF',
        '#DBE8FF',
        '#772D2D',
        '#793B0D',
        '#503E04',
        '#FDE9FF',
        '#2D1647',
        '#7E0E0E'
    ]
    editor.config.height = parseInt("{{ isset($options['min_height'])?$options['min_height']:400 }}")
    editor.config.menus = [
        'head',
        'bold',
        'fontSize',
        'fontName',
        'italic',
        'underline',
        'strikeThrough',
        'foreColor',
        'lineHeight',
        'justify',
        'link',
    ]
    editor.create()*/
</script>

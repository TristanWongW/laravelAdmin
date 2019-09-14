<script>
    // 关闭弹出ifram
    function closeLayerIfram(is_fresh) {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        if (is_fresh == 1) {
            parent.layui.table.reload('dataTable', {
                page: {curr: 1}
            });
        }
    }

    layui.use(['form'], function () {
        var form = layui.form;
        var post_url = $('.layui-form').attr('action');
        form.on('submit(*)', function (data) {
            $.post(post_url, data.field, function (res) {
                if (res.code == 0) {
                    layer.msg(res.msg, {time: 1500}, function () {
                        closeLayerIfram(1);
                    });
                } else {
                    layer.msg(res.msg);
                }
            }, "json");
            return false;
        });
    });

</script>
/**
 * 更新排序字段
 * @param table
 * @param id_name
 * @param id_value
 * @param field
 * @param obj
 */
function updateSort(table, id_name, id_value, field, obj) {
    var value = $(obj).val();
    if (!(/^[0-9]+$/.test(value))) {
        layer.msg('请输入数字', {icon: 1});
        return false;
    }

    $.ajax({
        url: "/admin/updateSort?table=" + table + "&id_name=" + id_name + "&id_value=" + id_value + "&field=" + field + "&value=" + value,
        success: function (res) {
            layer.msg(res.msg, {icon: 1});
        }
    });
}

// 修改指定表的指定字段值
function changeTableVal(table, id_name, id_value, field, value) {
    $.ajax({
        url: "/admin/changeTableVal?table=" + table + "&id_name=" + id_name + "&id_value=" + id_value + "&field=" + field + "&value=" + value,
        success: function (res) {
            layer.msg(res.msg, {icon: 1});
        }
    });
}

// 内联打开新的tab页面
function openNewTab(title, url) {
    parent.layui.index.openTabsPage(url, title);
}

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
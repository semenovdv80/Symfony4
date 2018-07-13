$(function() {

    /*order by table's fields*/

    $('#itemsTable').on('click', 'th', function () {
        var column = $(this).data('col');
        if (column == undefined) {
            return false;
        }

        var orderclass = $(this).attr('class');
        var order = (orderclass == 'order_asc' || orderclass == 'order_') ? 'desc' : 'asc';

        $.cookie("order_col", column, {
            expires: 10,
            path: '/'
        });
        $.cookie("order_type", order, {
            expires: 10,
            path: '/'
        });
        location.reload();
    });

    /* number of records per page */

    $('#rowsPerPage').on('change', function () {
        //console.log(this.val());
        this.form.submit();
    })

});

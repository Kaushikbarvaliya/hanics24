
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
$(document).ready(function () {

    var t = $('#theater_dataTable').DataTable({
        scrollX: true,
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
        },
        
        paging: true,
        ordering : false,
        lengthChange : true,
        serverSide : true,
        processing : true,
        ajax: function (data, callback,) {
            data.api_token = apiToken;
            data.client_token = apiClientToken;
            $.ajax({
                url: apiUrl+'theater/get_theaters',
                type: 'GET',
                data: data,
                dataType:'JSON',
                success:function(data){
                    callback(get_theaterList(data));
                }
            })
        }
    });

    $('.dataTables_processing').show();

    function get_theaterList(json) {

        var dataTableData = {};
        // dataTableData.draw = 1;
        dataTableData.recordsTotal = json.total_count;
        dataTableData.recordsFiltered = json.total_count;
        var dataTableRow = []

        let tableData = t.page.info();
        let Index = tableData.start;
        for (var i = 0; i < json.data.length; i++) {
            Index++;
            $tableRowID = i;
        
            let arr = [
                json.data[i].theater_id,
                `<a href="javascript:;" class="get_list_theater_screen">`+json.data[i].theater_name+`</a>`,
                json.data[i].site_name,
            ];
            arr['orderData'] = json.data[i];
        
            dataTableRow.push(arr);
        }
        dataTableData.data  = dataTableRow;
        return dataTableData;
    }

    const detailRows = [];
    t.on('click', 'tbody a.get_list_theater_screen', function () {
        let tr = event.target.closest('tr');
        let row = t.row(tr);
        let Listrecord = t.row(tr).data();
        let idx = detailRows.indexOf(tr.id);
     
        if (row.child.isShown()) {
            tr.classList.remove('details');
            row.child.hide();
     
            detailRows.splice(idx, 1);
        }
        else {
            $.ajax({
                url: apiUrl+'theater/get_screens',
                type: 'GET',
                data: {
                    api_token: apiToken,
			        client_token: apiClientToken,
                    theater_serial:Listrecord.orderData.theater_token
                },
                dataType:'JSON',
                success:function(data){
                    tr.classList.add('details');
                    row.child(viewTheaterScreens(data)).show();
             
                    // Add to the 'open' array
                    if (idx === -1) {
                        detailRows.push(tr.id);
                    }
                }
            })
        }
    });

    function viewTheaterScreens(data){
        if(data.count){
            $record = data.data;
            return (
                '<div class="callout callout-info callout-details">'+
                    '<table class="table table-callout-details mb-0">'+
                        '<thead>'+
                            '<tr>'+
                                '<th> Screen ID </th>'+
                                '<th> Theater ID </th>'+
                                '<th> Screen Name </th>'+
                                '<th> Site Name </th>'+
                                '<th> Theater Name </th>'+
                                '<th> Longitude </th>'+
                                '<th> Latitude </th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>'+
                            '<tr>'+
                                '<td>'+ $record.cloud_screen_id +'</td>'+
                                '<td>'+ $record.cloud_theater_id +'</td>'+
                                '<td>'+ $record.screen_name +'</td>'+
                                '<td>'+ $record.site_name +'</td>'+
                                '<td>'+ $record.theater_name +'</td>'+
                                '<td>'+ $record.longitude +'</td>'+
                                '<td>'+ $record.latitude +'</td>'+
                            '</tr>'+
                        '</tbody>'+
                    '</table>'+
                '</div>'
            );
        }else{
            return ('No screens available');
        }
    }
});
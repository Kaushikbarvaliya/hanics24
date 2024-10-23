
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
$(document).ready(function () {

    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "date-uk-pre": function (a) {
            var ukDatea = a.split('/');
            return new Date(ukDatea[2] + '/' + ukDatea[0] + '/' + ukDatea[1]).getTime();
        },

        "date-uk-asc": function (a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-uk-desc": function (a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });

    var t = $('#deviceList_dataTable').DataTable({
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
                url: apiUrl+'devices/get_device_list',
                type: 'GET',
                // data: {
                //     api_token: '63004f19573f434d9de90ecf8798123e',
                //     client_token: '2621d022d7b14b1882f0ca4699909e45',
                //     page:data.start,
                //     per_page: data.page.len()
                // },
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
                Index,
                `<a href="javascript:;" class="get_list_theater_screen">`+json.data[i].device_name+`</a>`,
                json.data[i].device_serial,
                json.data[i].device_status,
                json.data[i].device_type,
                json.data[i].site_name,
                json.data[i].theater_name,
                format_date(json.data[i].device_created)
            ];
            arr['orderData'] = json.data[i];
        
            dataTableRow.push(arr);
        }
        dataTableData.data  = dataTableRow;
        return dataTableData;
    }

    function format_date(date) {
        var date = new Date(date);
        var month = date.getMonth() + 1;
        if (date.getDate() < 10) {
            $get_day = '0' + date.getDate();
        } else {
            $get_day = date.getDate();
        }
        return (month.toString().length > 1 ? month : "0" + month) + "/" + $get_day + "/" + date.getFullYear();
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
                url: apiUrl+'devices/get_device_details',
                type: 'GET',
                data: {
                    api_token: apiToken,
			        client_token: apiClientToken,
                    device_serial:Listrecord.orderData.device_serial
                },
                dataType:'JSON',
                success:function(data){
                    tr.classList.add('details');
                    row.child(viewDeviceDetail(data)).show();
             
                    // Add to the 'open' array
                    if (idx === -1) {
                        detailRows.push(tr.id);
                    }
                }
            })
        }
    });

    function viewDeviceDetail(data){
        if(data.data){
            $record = data.data[0];
            return (
                '<div class="callout callout-info callout-details">'+
                    '<table class="table table-callout-details mb-0">'+
                        '<thead>'+
                            '<tr>'+
                                '<th> Device Name </th>'+
                                '<th> Device Serial </th>'+
                                '<th> Device Type </th>'+
                                '<th> Last seen </th>'+
                                '<th> Local IP </th>'+
                                '<th> RSSI </th>'+
                                '<th> Status </th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>'+
                            '<tr>'+
                                '<td>'+ $record.device_name +'</td>'+
                                '<td>'+ $record.device_serial +'</td>'+
                                '<td>'+ $record.device_type +'</td>'+
                                '<td>'+ $record.last_seen +'</td>'+
                                '<td>'+ $record.local_ip +'</td>'+
                                '<td>'+ $record.rssi +'</td>'+
                                '<td>'+ $record.status +'</td>'+
                            '</tr>'+
                        '</tbody>'+
                    '</table>'+
                '</div>'
            );
        }else{
            return ('No details available');
        }
    }
});
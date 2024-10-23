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

    var t = $('#services_dataTable').DataTable({
        scrollX: true,
        processing: true,
        "drawCallback": function (settings) {
            $('[data-toggle="tooltip"]').tooltip()
        },
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
        },
        pageLength: 10,
        buttons: {
            buttons: [
                { extend: 'excel', text: 'Excel <i class="fas fa-file-export ml-1"></i>', className: 'btn-primary btn-sm px-3' }
            ]
        },
        paging: true,
        ordering : false,
        lengthChange : true,
        serverSide : true,
        processing : true,
        ajax: function (data, callback, settings) {
            let tableData = new $.fn.dataTable.Api(settings);
            data.api_token = apiToken;
            data.client_token = apiClientToken;
            $.ajax({
                url: apiUrl+'services/get_service_list?theater_id=1&cloud_screen_id=1&service_status=1&page=0',
                type: 'GET',
                data: data,
                dataType:'JSON',
                success:function(data){
                    callback(get_services(data));
                }
            })
        }
    });

    $('.dataTables_processing').show();

    function get_services(json) {

        var dataTableData = {};
        // dataTableData.draw = 1;
        dataTableData.recordsTotal = json.total_count;
        dataTableData.recordsFiltered = json.total_count;
        var dataTableRow = []

        let tableData = t.page.info();
        let Index = tableData.start;
        for( var i=0; i < json.data.length ; i++){ 
            Index++;

            $tableRowID = i;

            let arr = [
                json.data[i].cloud_screen_id,
                json.data[i].device_id,
                json.data[i].device_name,
                json.data[i].device_serial,
                json.data[i].start_time,
                json.data[i].end_time,
                json.data[i].screen_name,
            ];
            arr['orderData'] = json.data[i];

            dataTableRow.push(arr);
        }
        dataTableData.data  = dataTableRow;
        return dataTableData;
    }

});
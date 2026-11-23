$(function () {
    onQueryApplicant();
});
function onQueryApplicant() {
    $("#tb_list_applicant").DataTable({
        ajax: {
            type: "GET",
            url: "../data/data_list_applicant.php?Action=GetDataListApp",
            dataSrc: function (res) {
                return res;
            }
        },
        columns: [
            {
                data: "ID",
            },
            {
                data: "FullName",
            },
            {
                data: "PhoneNumber",
            },
            {
                data: "Email",

            },
            {
                data: "File_name",
            },
        ],
        destroy: true,
        select: true,
        searching: false,
        ordering: true,
        info: true,
    });

}
$(document).ready(function (e) {
    const ajaxFunc = (...params) => {
        $.ajax({
            url: `${params[0]}`,
            dataType: "json",
            success: function (data) {
                if (params.length > 1) {
                    params[1](data);
                }
            },
        });
    };

    // Kebutuhan Modal Box Bukti Pembayaran
    const modalBox = (data) => {
        console.log(data);
        let ext = data.file.split(".").pop().toLowerCase();
        if (ext != "pdf") {
            $(".modal-dialog").removeClass("modal-lg");
            $(".modal-body").html(
                `<img src="/storage/${data.file}" alt="" class="w-100">`
            );
        } else {
            $(".modal-dialog").addClass("modal-lg");
            $(".modal-body").html(
                `<embed class="pdfobject" type="application/pdf" title="Embedded PDF" src="/storage/${data.file}" style="overflow: auto; width: 100%; height: 80vh;">`
            );
        }
        $(".modal-title").html(`Tim ${data.nama_tim}`);
        $(".modal-footer").html(modalFooter(data));
    };

    const modalFooter = (data) => {
        let ext = data.file.split(".").pop().toLowerCase();
        let str =
            '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
        if (ext != "pdf") {
            str += `<a href="/storage/${data.file}" class="btn btn-primary" download="bukti_bayar_tim_${data.nama_tim}"><i class="bi bi-cloud-download"></i> Bukti</a>`;
        } else {
            str += `<a href="/storage/${data.file}" class="btn btn-primary" download="data_tim_${data.nama_tim}"><i class="bi bi-cloud-download"></i> Identitas Tim</a>`;
        }
        return str;
    };

    // $(".btn-modal").on("click", function (e) {
    //     let id = $(this).data("team-id");
    //     let url = `/dashboard/files/${id}`;
    //     ajaxFunc(url, modalBox);
    // });

    // $(e.target).

    // Akhir Kebutuhan Modal Box Bukti Pembayaran

    // Kebutuhan Send Email

    // $("#select-all").on("change", function () {
    //     if ($("#select-all").prop("checked")) {
    //         $(".chk-participant").prop("checked", true);
    //     } else {
    //         $(".chk-participant").prop("checked", false);
    //     }
    // });

    // $("#send-email").on("click", function () {
    //     $("#checkParticipant").submit();
    // });

    // Akhir Kebutuhan Send Email

    // Kebutuhan Filtering
    const ajaxParticipants = (row) => {
        $("#container").html(row);
    };

    $("body").on("click", function (e) {
        if ($(e.target).hasClass("dropdown-item")) {
            let filter = $(e.target).text().toLowerCase();
            let id_lomba = $(e.target).data("competition");
            let slug = $(e.target).data("abbreviation");
            let url = `/dashboard/participants-${slug}`;
            if (filter != "all") {
                $(".pagination").addClass("d-none");
                url = `/dashboard/teams-ajax?status=${filter}&id_lomba=${id_lomba}&slug=${slug}`;
            } else {
                $(".pagination").removeClass("d-none");
            }
            $.get(url, {}, ajaxParticipants);
        } else if ($(e.target).attr("id") == "select-all") {
            if ($(e.target).attr("id", "select-all").prop("checked")) {
                $(".chk-participant").prop("checked", true);
            } else {
                $(".chk-participant").prop("checked", false);
            }
        } else if ($(e.target).attr("id") == "send-email") {
            $("#checkParticipant").submit();
        } else if ($(e.target).hasClass("btn-bukti-bayar")) {
            let nama = $(e.target).data("team-name");
            let url = `/dashboard/files/${nama}?type=jpg`;
            ajaxFunc(url, modalBox);
        } else if ($(e.target).hasClass("btn-identitas-tim")) {
            let nama = $(e.target).data("team-name");
            let url = `/dashboard/files/${nama}?type=pdf`;
            ajaxFunc(url, modalBox);
        } else if ($(e.target).hasClass("btn-hapus")) {
            var form = $("#showDelete");
            e.preventDefault();
            swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        }
    });
    // Akhir Kebutuhan Filtering
});

$(".pay-button").on("click", function () {
    // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
    console.log("test");
    console.log($(this).data("token"));
    window.snap.pay($(this).data("token"), {
        onSuccess: function (result) {
            /* You may add your own implementation here */
            alert("payment success!");
            console.log(result);
        },
        onPending: function (result) {
            /* You may add your own implementation here */
            alert("wating your payment!");
            console.log(result);
        },
        onError: function (result) {
            /* You may add your own implementation here */
            alert("payment failed!");
            console.log(result);
        },
        onClose: function () {
            /* You may add your own implementation here */
            alert("you closed the popup without finishing the payment");
        },
    });
});

const modalPayment = (data) => {
    console.log(data);
    $(".pay-method").html(data.result.payment_type);
    $(".type-bank").html(data.result.va_numbers[0].bank);
    $(".va-number").html(data.result.va_numbers[0].va_number);
    $("#loading").modal("hide");
    $("#exampleModal").modal("show");
};

const requestPayment = (url, data, success) => {
    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function (data) {
            console.log("test");
            success(data);
        },
        dataType: "json",
    });
};

// Awal payment
$(".btn-payment").on("click", function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let url = "/dashboard/payment";
    let data = {
        team_id: $(this).data("team-id"),
    };
    if ($(this).text() == "BRI VA") {
        data.bank = "bri";
        // url += `${data.team_id}/bri`;
    } else if ($(this).text() == "BCA VA") {
        data.bank = "bca";
        // url += `${data.team_id}/bca`;
    } else if ($(this).text() == "BNI VA") {
        data.bank = "bni";
        // url += `${data.team_id}/bni`;
    }
    console.log(data);
    $("#loading").modal("show");
    requestPayment(url, data, modalPayment);
});
// Akhir Payment

// Enable Tooltips
const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

$(".btn-number").on("click", function () {
    // $(this).removeClass("bi-clipboard");
    // $(this).addClass("bi-clipboard-check-fill");
    // setTimeout(() => {
    //     $(this).removeClass("bi-clipboard-check-fill");
    //     $(this).addClass("bi-clipboard");
    // }, 1500);
    // let va_number = document.querySelector(".bi-clipboard");
    // var clipboard = new ClipboardJS(".btn-number");
    // console.log(clipboard);
    // clipboard.on("success", function (e) {
    //     console.info("Action:", e.action);
    //     console.info("Text:", e.text);
    //     console.info("Trigger:", e.trigger);
    // });
    // clipboard.on("error", function (e) {
    //     console.info("Action:", e.action);
    //     console.info("Text:", e.text);
    //     console.info("Trigger:", e.trigger);
    // });
    // console.log($(".va-number").html());
});

let counter = 1;
let interval;
$("#btn-daftar").on("click", function () {
    let baseTicket = 100000;
    let ticketPrice;
    let date = new Date();
    interval = setInterval(() => {
        if (counter <= 500) {
            ticketPrice =
                counter +
                date.getDate() +
                date.getMinutes() +
                date.getSeconds() +
                date.getMilliseconds();
            ticketPrice = baseTicket - ticketPrice;
            if (counter == 100) {
                counter = 1;
            }
            counter++;
        }
        console.log(ticketPrice);
    }, 1);
    // setTimeout(() => {
    // }, timeout);
});

$("#btn-stop").on("click", function () {
    clearInterval(interval);
});

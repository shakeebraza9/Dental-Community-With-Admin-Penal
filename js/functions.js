function start_loader() {
    $("#loader").show()
}

function video(e) {
    $(".btnvideo").hide(), $(".myevents-form").empty(), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").addClass("myevents-div_"), $(".myevents-form").load("video.php?url=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function daysoff(e = !1) {
    $(".btnvideo").hide(), $(".myevents-form").empty(), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").addClass("myevents-div_"), $(".myevents-form").load("daysoff.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function referfriend() {
    $(".btnvideo").hide(), $(".myevents-form").empty(), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").addClass("myevents-div_"), $(".myevents-form").load("referfriend.php", (function() {
        $(".background_side").fadeToggle(), $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function feedbackForm() {
    $(".btnvideo").hide(), $(".myevents-form").empty(), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").addClass("myevents-div_"), $(".myevents-form").load("feedback_form.php", (function() {
        $(".background_side").fadeToggle(), $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function leaves(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("leaveform.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function employeeleaveform(e = !1) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("employeeleaveform.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function myevents() {
    $("body").addClass("flow_hidden"),
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("myevents.php", (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function addnotescomments(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("client-addnotescomments.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function addClient(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("client-statusform.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function addnotes(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("client-addnotes.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function changeColor(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("client-changeColor.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function changeStatus(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("client-changeStatus.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function customlog() {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("customlog.php", (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function close_newpopup() {
    $(".new-popup,.background_side").hide()
    // $(".helloween,.background_side").hide()
    $(".fixed_side").removeClass("fixed_side_")
}

function checkin() {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("checkinout.php?type=checkin")
}

function covid() {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("covid-form.php"), $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600), $("#loader").fadeOut(600)
}

function newuserWellcome() {
    $(".btnvideo").show(), $(".myevents-form").empty(), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").addClass("myevents-div_"), $(".myevents-form").load("video.php?url=EJUtPIhK-Bg", (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function feedbackRating(e, t) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("feedbackRating.php?assign_id=" + e + "&test_id=" + t, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function mockInspectionForm(e = !1, t = !1, i = !1, d = !1, n = !1, s = !1) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("mock_inspection_Form.php?safe=" + e + "&safearray=" + t + "&effective=" + i + "&wellled=" + d + "&responsive=" + n + "&caring=" + s, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function checkout() {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("checkinout.php?type=checkout")
}

function postadd(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("postadd?user=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function secure_delete(e) {
    return e = void 0 !== e ? e : "Are you sure you want to Delete?", bool = confirm(e), 0 != bool
}

function EditeventDate() {
    secure_delete("Are You Sure You Want To Edit Due Date ?") && ($(".duedate").show(), $(".duedate").find("input").attr("readonly", !0), $(".duedate").find("input").attr("required", !0))
}

function Edit_recurring_duration() {
    secure_delete("Are You Sure You Want To Edit Recurring Duration ?") && ($(".Edit_recurring_duration").show(), $(".Edit_recurring_duration").find("input").attr("readonly", !0), $(".Edit_recurring_duration").find("input").attr("required", !0))
}

function submitevent(e) {
    $(".myevents-form").empty(), color = $("#" + e).attr("data-type"), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-div").addClass(color), $(".myevents-form").load("submitevent.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}
function editevent(e) {
      $(".myevents-form").empty(),
        color = $("#" + e).attr("data-type"),
        $(".fixed_side").toggleClass("fixed_side_"),
        $("body").addClass("flow_hidden"),
        $(".myevents-div").toggleClass("myevents-div_"),
        $(".myevents-div").addClass(color),
        $(".myevents-form").load("editevent.php?id=" + e + "&new", (function() {
          $(".myevents-div #loader").fadeOut(600),
            $(".background_side").fadeOut(600)
        }));
      $("[title='chat widget']").parent("div").hide();
    }

// function editevent(e) {
//     $(".myevents-form").empty(), color = $("#" + e).attr("data-type"), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-div").addClass(color), $(".myevents-form").load("editevent.php?id=" + e + "&new", (function() {
//         $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
//     })), $("[title='chat widget']").parent("div").hide()
// }

function printCompletedEvent(e) {
    $(".myevents-form").empty(), window.location.replace("https://smartdentalcompliance.com/new/pdf/pdf.php?create=pdf&id=" + e)
}

function myevents(e) {
    // console.log(e);
    $(".myevents-form").empty(), color = $("#" + e).attr("data-type"), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-div").addClass(color), $(".myevents-form").load("myevents.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function myeventsReopen(e) {
    $(".myevents-form").empty(), $(".myevents-form").load("myevents.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function copyEvents(e) {
    secure_delete("Are You Sure You Want To Copy This Event To My Event?") && (console.log(e), $.ajax({
        type: "POST",
        url: "ajax_call.php?page=copyEvents",
        data: "value=" + e
    }).done((function(e) {
        console.log(e), $(".myevents-form").empty(), color = $("#" + e).attr("data-type"), $(".myevents-div").addClass(color), $(".myevents-form").load("myevents.php?id=" + e + "&new", (function() {})), $("[title='chat widget']").parent("div").hide()
    })))
}


function submitMYevent(e) {
    $(".myevents-form").empty(), color = $("#" + e).attr("data-type"), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-div").addClass(color), $(".myevents-form").load("submiteventFromDashboard.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function eventsAll() {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("eventsAll.php", (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function myuploads() {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("myuploadsform.php", (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}
// function uploadcompliancetemplate(e) {
//     $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("uploadComplianceTemplateForm.php?t=" + e, (function() {
//         $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
//     })), $("[title='chat widget']").parent("div").hide()
// }
function myuploadsdit(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("myuploadsform.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function myremindersedit(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("reminderEdit.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function txtform(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("txtform.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function editStockmin_stock(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("editStockmin_stock.php?id=" + e + "p=new", (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function addDeductQty(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("addDeductQty.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function editStockLocation(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("editStockLocation.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function editexpiryDate(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("editexpiryDate.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function initialcpdFormReset(e) {
    e = e, console.log(e), "" == e ? $(".errmsg").text("All Fields Required") : ($(this).attr("disabled", !0), $(".errmsg").text(""), $.ajax({
        type: "post",
        data: {
            resetId: e
        },
        url: "ajax_call.php?page=resetCPDform"
    }).done((function(e) {
        "1" == e ? location.reload() : $(this).removeAttr("disabled", !1)
    })))
}

function initialcpdForm(e = !1, t = !1, i = !1, d = !1) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("cpd-form-edit.php?lable=" + e + "&name=" + t + "&id=" + i + "&user" + d, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}
function practicecpd() {
    $("body").addClass("flow_hidden"),
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("practiceCpdForm.php", (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function recruitment() {
    $("body").addClass("flow_hidden"),
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("recruitmentform.php", (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function folder(e) {
    window.location.replace("profile-detail?user=" + e)
}

function documentsadd(e = !1, t = !1, i = !1) {
    $(".myevents-form").empty(), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").removeClass("orangeborder"), $(".myevents-form").load("adddocumentsform.php?page=" + e + "&user=" + t + "&cat=" + i, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function documentInsert_profile_detail(e = !1, t = !1, i = !1) {
    $(".myevents-form").empty(), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").removeClass("orangeborder"), $(".myevents-form").load("adddocumentsform2.php?page=" + e + "&user=" + t + "&cat=" + i, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function documentInsert(e, onboardPage = "") {
    $(".myevents-form").empty(), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").removeClass("orangeborder"), $(".myevents-form").load("documentsform.php?type=insert&id=" + e+"&onboardPage="+onboardPage, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function faqview(e) {
    $("body").addClass("flow_hidden"),$(".myevents-form").empty(), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").removeClass("orangeborder"), $(".myevents-form").load("faqView.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function documentUpdate(e) {
    $(".myevents-form").empty(), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").removeClass("orangeborder"), $(".myevents-form").load("documentsform.php?type=update&id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function documentselectcpdpdf(e, t, i = !1, d = !1, n = !1) {
    $(".myevents-form").empty(), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").removeClass("orangeborder"), $(".myevents-form").load("documentSelect.php?id=" + e + "&user=" + t, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function documentView(e) {
    $(".myevents-form").empty(), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").removeClass("orangeborder"), $(".myevents-form").load("documentsform.php?type=view&id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function documentViewGroup(e) {
    $(".myevents-form").empty(), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-div").removeClass("orangeborder"), $(".myevents-form").load("documentsformGroup.php?type=view&id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function documentallfileView(e) {
    $(".myevents-form").empty(), $(".myevents-div").removeClass("orangeborder"), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-form").load("documentsform.php?type=allfile&id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function EditShift(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("addshift.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function addshift(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("addshift.php", (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function lieuform(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("lieuform.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function amendRota(e) {
    $(".myevents-form").empty(), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("amendRotaform.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function stickynotesClick() {
    $("._notes").toggleClass("content_Sticky_"), $(".contentSticky").show()
}

function WindowPrint() {
    $("[title='chat widget']").parent("div").hide(), window.print()
}


$((function() {
    (new WOW).init(), $('[data-toggle="tooltip"]').tooltip(), $(".datepicker").datepicker({
        dateFormat: "d-M-yy",
        changeMonth: !0,
        changeYear: !0,
        yearRange: "-80:+20",
        showButtonPanel: !0
    }),
     $(".datepickerr").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: !0,
        changeYear: !0,
        yearRange: "-80:+20",
        showButtonPanel: !0
    }), 
    $(".datepickerr").datepicker({
        dateFormat: "d-M-yy",
        changeMonth: !0,
        changeYear: !0,
        yearRange: "-80:+20",
        showButtonPanel: !0
    }), $(".timepicker").timepicker({
        hourGrid: 4,
        minuteGrid: 10,
        timeFormat: "hh:mm tt"
    }), $("#banner").ulslide({
        effect: {
            type: "crossfade",
            axis: "x",
            showCount: 0,
            distance: 20
        },
        pager: "#slide-pager a",
        nextButton: ".banner_left",
        prevButton: ".banner_right",
        duration: 900,
        mousewheel: !1,
        autoslide: 14e3,
        animateOut: "fadeOut",
        animateIn: "fadeIn"
    }), $(".fancybox").fancybox(), $(".header_side .col1_btn,.col10 .col1_btn").click((function() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow"), $(".background_side").fadeToggle(), $(".col101_book").fadeToggle()
    }))
    // , $(".webBtn").click((function() {
    //     $("html, body").animate({
    //         scrollTop: 0
    //     }, "slow"), $(".background_side").fadeToggle(), $(".col101_webinar").fadeToggle(),
    //     $(".webinarTitle").val($(this).children(".webinarName").val()),
    //     $(".zoomLink").val($(this).children(".zoomLink").val())
    // })),$(".freeResourseDownloadBtn").click((function() {
    //     if($("#resourceFormSubmit").val() == 1){
    //         alert('Please refresh the page to download again');
    //       location.reload();
    //         return false
    //     }
    
    //     $("html, body").animate({
    //         scrollTop: 0
    //     }, "slow"), $(".background_side").fadeToggle(), $(".col101_free_resource_registration").fadeToggle(),
    //     $(".resourceTitle").val($(this).children(".title").val()),
    //     $(".resourceLink").val($(this).children(".file_id").val())

    // }))
    , $("#tabs .col4_top_box .col1_btn,#tabs .col15 .col1_btn,#tabs .col3 .col1_btn").click((function() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow"), $(".background_side").fadeToggle(), $(".col101_cart").fadeToggle(), $("#checkoutBtn").prop("disabled", !0)
    })), $("#tabs .col1_btn22").click((function() {
        name = $(this).find("a").attr("data-name"), $(".col101_cart2 h1").text(name), $(".col101_cart2").find(".pname").val(name), $("html, body").animate({
            scrollTop: 0
        }, "slow"), $(".background_side").fadeIn(), $(".col101_cart2").fadeToggle()
    })), $(".close_popup").click((function() {
        $(".background_side").fadeOut(), $(".col101").fadeOut()
    })), $("#menu").mmenu({
        extensions: ["effect-menu-zoom", "effect-panels-zoom", "pagedim-black", "theme-dark"],
        offCanvas: {
            position: "left"
        },
        counters: !0,
        iconPanels: !0,
        navbars: [{
            position: "top"
        }]
    }), $(window).scroll((function() {
        var e = $(".header");
        $(window).scrollTop() >= 100 ? e.addClass("sticky") : e.removeClass("sticky")
    })), $(".next_button").click((function() {
        $(".next_button1").show(), $(this).hide()
    })), $("#tabs").tabs(), $("#tabs_").tabs(), $("#stocktabs").tabs(), $(".col1_btn2").click((function() {
        $(".col5").toggleClass("col5_")
    })), $(".col1_btn2").click((function() {
        $(".fixed_side").toggleClass("fixed_side_")
    })), $(".col5_close").click((function() {
        $(".fixed_side").removeClass("fixed_side_"), $(".col5").removeClass("col5_"), $(".myevents-div").removeClass("myevents-div_"), $(".myevents-div").removeClass("redborder"), $(".myevents-div").removeClass("blueborder"), $(".myevents-div").removeClass("greenborder"), $("[title='chat widget']").parent("div").attr("style", "display: block !important;position: fixed !important"), setTimeout((function() {
            $(".myevents-form").empty(), $(".myevents-div #loader").show()
        }), 1e3)
    })), $(".col4_main h5").click((function() {
        var e = $(this).attr("class");
        $(this).hasClass("atv") || ($(this).parent("div").find("h5").removeClass("atv"), $(this).addClass("atv"), $(this).parent("div").find(".col4_main_left ul li").hide(), $(this).parent("div").find(".col4_main_left ul li." + e).show(), $(this).parent("div").find(".file-box .file-box-desc").hide(), $(this).parent("div").find(".file-box div." + e).show())
    })), $(".cpd-courses h5").click((function() {
        $(".cpd-courses h5").removeClass("atv"), $(this).addClass("atv");
        var e = $(this).attr("data-filter");
        return $(".grid").isotope({
            filter: e,
            animationOptions: {
                duration: 750,
                easing: "linear",
                queue: !1
            }
        }), !1
    })), $(".optn").on("change", (function() {
        var e = $("#optn").val();
        "all" == e ? $(".main-row").show() : $(".main-row").hide(), $(".main-row").find("h5:contains(" + e + ")").parents(".main-row").show()
    })), jQuery.expr[":"].contains = function(e, t, i) {
        return jQuery(e).text().toUpperCase().indexOf(i[3].toUpperCase()) >= 0
    }, $("#kywd").bind("keyup change", (function() {
        var e = $("#kywd").val();
        $(".main-row-down ul li").hide(), $(".main-row-down ul li:contains(" + e + ")").show(), "all" == $("#optn").val() && $(".main-row").each((function() {
            if ($(this).find('.main-row-down ul li[style="display: flex;"]').length > 0) return $(this).show();
            $(this).hide()
        }))
    })), $(".close_btn").click((function() {
        $(".popup").fadeOut(600)
    })), $(".fancybox").fancybox();
    // var e = setInterval((function() {
    //     var t, i;
    //     new Date;
    //     t = document.createElement("script"), i = document.getElementsByTagName("script")[0], t.async = !0, t.src = "https://embed.tawk.to/5cdbdb8ed07d7e0c6393b33a/default", t.charset = "UTF-8", t.setAttribute("crossorigin", "*"), i.parentNode.insertBefore(t, i), clearInterval(e)
    // }), 100);
    setTimeout((function() {
        $("#loader").fadeOut(600), $(".col5 .tble table td:first-child,.col5 .tble table th:first-child").each((function() {
            var e = $(this).innerHeight();
            e = parseInt(e) - 1;
            $(this).css({
                position: "fixed",
                display: "flex",
                height: e
            })
        }))
    }), 500),
    
 $(".link_menu").click((function() {
        $(".links_area").addClass("showmenu")
    })),
    
    $(".close_side").click((function() {
        $(".links_area").removeClass("showmenu")
    })), 
    
    $(".u-vmenu").vmenuModule({
        Speed: 100,
        autostart: !0,
        autohide: !0
    }), $("#tabs").tabs(), $("#dialog").dialog({
        title: "Notice!",
        dialogClass: "alert",
        width: 400,
        position: {
            my: "left bottom",
            at: "left bottom",
            of: window
        }
    }), $(".noti").click((function() {
        $("body").css("overflow", "hidden"), $(".notify").css("transform", "scaleX(1)"), $(".fixed_side").toggleClass("fixed_side_")
    })), $(".notif").click((function() {
        $("body").css("overflow", "hidden"), $(".notifys").css("transform", "scaleX(1)"), $(".fixed_side").toggleClass("fixed_side_")
    })), $(".notify-top i").click((function() {
        $(".notify").css("transform", "scaleX(0)"), $(".fixed_side").toggleClass("fixed_side_"), $("body").css("overflow", "visible")
    })), "interactive" === document.readyState && $(".listitems").html((function() {
        return $(this).children().sort(((e, t) => $(e).text().trim().localeCompare($(t).text().trim())))
    })), $(".main-row-top i").click((function() {
        $(this).parent("div").next(".main-row-down").slideToggle("slow"), $(this).toggleClass("fa-chevron-up")
    })), $(".main-row-tops i").click((function() {
        $(this).next(".main-row-down").slideToggle("slow"), $(this).toggleClass("fa-chevron-up")
    })), $("#src-event").bind("keyup", (function() {
        var e = $(this).val();
        $(".col4_main_left ul li").hide(), $(".col4_main_left ul li:contains(" + e + ")").show()
    })), $("#profile-src-event").bind("keyup", (function() {
        var e = $(this).val();
        $(".user-box").hide(), $(".user-box:contains(" + e + ")").show()
    })), $("#pro-src-notif").bind("keyup", (function() {
        var e = $(this).val();
        $(".notifall").hide(), $(".notifall:contains(" + e + ")").show()
    })), $('[data-toggle="tooltip"]').tooltip()
})), $("#lieu").click((function() {
    $(".right_side").load("lieu.php .right_side"), $(".sidemenu li a").removeClass("active"), $("#hrManagement").addClass("active")
})), $(".clientAddTbl_all_users").on("change", (function() {
    var e = $("#clientAddTbl_all_users").val();
    "all" == e ? $(".main-row").show() : $(".main-row").hide(), $(".main-row").find("div:contains(" + e + ")").parents(".main-row").show()
})), $(".clientAddTbl_all_users_services").on("change", (function() {
    var e = $("#clientAddTbl_all_users_services").val();
    "all" == e ? $(".main-row").show() : $(".main-row").hide(), $(".main-row").find("div:contains(" + e + ")").parents(".main-row").show()
})), $("#pProductSearchOPTION_Minimum").bind("keyup change", (function() {
    var e = $("#pProductSearchOPTION_Minimum").val();
    $(".removeKeyPress").hide(), $(".main-row div:contains(" + e + ")").show(), $("#clientAddTbl_all_users").val("all").change(), $("#clientAddTbl_all_users_services").val("all").change(), "all" == $("#clientAddTbl_all_users").val() && $(".main-row").each((function() {
        return $(this).show()
    }))
})), $("#searchpurchaseReceipt").bind("keyup change", (function() {
    var e = $("#searchpurchaseReceipt").val();
    $("tbody tr").hide(), $("tbody tr:contains(" + e + ")").show(), console.log(e)
})), $("#clientAddTbl_all_users_serviceskywd").bind("keyup change", (function() {
    var e = $("#clientAddTbl_all_users_serviceskywd").val();
    $(".removeKeyPress").hide(), $(".main-row div:contains(" + e + ")").show(), $("#clientAddTbl_all_users").val("all").change(), $("#clientAddTbl_all_users_services").val("all").change(), "all" == $("#clientAddTbl_all_users").val() && $(".main-row").each((function() {
        return $(this).show()
    }))
})), $(".commentbtn").click((function() {
    $(this).next().next().toggleClass("cmtHideShow"), $(this).next().next().next().toggleClass("cmtHideShow");
    $(".grid").isotope({})
})), $(".col5_close_sticky").click((function() {
    $(".saad").toggleClass("content_Sticky_"), $(".contentSticky").hide()
}));
var timer, timerFinish, timerSeconds, piesiteFired = 0;

function drawTimer(e, t) {
    $("#pie_" + e).html('<div class="percent"></div><div id="slice"' + (t > 50 ? ' class="gt50"' : "") + '><div class="pie"></div>' + (t > 50 ? '<div class="pie fill"></div>' : "") + "</div>");
    var i = 3.6 * t;
    $("#pie_" + e + " #slice .pie").css({
        "-moz-transform": "rotate(" + i + "deg)",
        "-webkit-transform": "rotate(" + i + "deg)",
        "-o-transform": "rotate(" + i + "deg)",
        transform: "rotate(" + i + "deg)"
    }), t = Math.floor(100 * t) / 100, arr = t.toString().split("."), intPart = arr[0], $("#pie_" + e + " .percent").html('<span class="int">' + intPart + '</span><span class="symbol">%</span>')
}

function stoppie(e, t) {
    var i = 100 - (timerFinish - (new Date).getTime()) / 1e3 / timerSeconds * 100;
    (i = Math.floor(100 * i) / 100) <= t ? drawTimer(e, i) : (t = $("#pie_" + e).data("pie"), arr = t.toString().split("."), $("#pie_" + e + " .percent .int").html(arr[0]))
}

function end_session() {
    $.ajax({
        url: "../ajax_call.php?page=SessionStart",
        type: "post"
    }).done((function(e) {
        "1" == e && (console.log("session start"), setTimeout("end_session()", 1e6))
    }))
}

function WindowPrint() {
    $("[title='chat widget']").parent("div").hide(), window.print()
}

function WindowBack() {
    $("[title='chat widget']").parent("div").attr("style", "display: block !important;position: fixed !important")
}





function viewComplaintIssue(e) {
    $(".myevents-form").empty(), $(".myevents-div").removeClass("orangeborder"), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-form").load("viewComplaintIssue.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function viewIncidentIssue(e) {
    $(".myevents-form").empty(), $(".myevents-div").removeClass("orangeborder"), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-form").load("viewIncidentIssue.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function viewComplainFile(e) {
    $(".myevents-form").empty(), $(".myevents-div").removeClass("orangeborder"), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-form").load("viewComplainFile.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function addNewProductByUser(e) {
    var t = e;
    t = t.replace(" ", "_"), str1 = t.replace(" ", "_"), str2 = str1.replace(" ", "_"), str3 = str2.replace(" ", "_"), str4 = str3.replace(" ", "_"), console.log(str4), $(".myevents-form").empty(), $(".myevents-div").removeClass("orangeborder"), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-form").load("addNewProductByUser.php?id=" + str4, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function changeStatuses(e) {
    secure_delete("Are You Sure You Want To Change Status ?") && (console.log(e), $.ajax({
        type: "POST",
        url: "ajax_call.php?page=changeStatuses",
        data: "value=" + e
    }).done((function(e) {
        console.log(e), location.replace("reportIssue")
    })))
}

function changeStatusesDel(e) {
    secure_delete("Are You Sure You Want To Delete ?") && (console.log(e), $.ajax({
        type: "POST",
        url: "ajax_call.php?page=changeStatusesDel",
        data: "value=" + e
    }).done((function(e) {
        console.log(e), location.replace("reportIssue")
    })))
}

function addTobasket(e) {
    secure_delete("Are You Sure You Want To Add This Product ?") && (console.log(e), $.ajax({
        type: "POST",
        url: "ajax_call.php?page=addTobasket",
        data: "value=" + e
    }).done((function(e) {
        console.log(e), location.replace("stock")
    })))
}
$(document).ready((function() {
    $('[data-toggle="tooltip"]').tooltip();
    var e = $(window),
        t = $(window).height(),
        i = .9 * $(window).height();

    function d() {
        var d = e.scrollTop();
        $(".trigger").each((function() {
            var e = $(this).offset().top;
            d + i > e || t > e ? $(this).each((function(e, t) {
                var i = $(this).data("percentage");
                $(this).css("height", i + "%"), $(this).prop("Counter", 0).animate({
                    Counter: $(this).data("percentage")
                }, {
                    duration: 2e3,
                    easing: "swing",
                    step: function(e) {
                        $(this).text(Math.ceil(e))
                    }
                })
            })) : $(this).each((function(e, t) {
                $(this).css("height", 0)
            }))
        })), $(".chartBarsHorizontal .bar").each((function() {
            var e = $(this).offset().top;
            d + i > e || t > e ? $(this).each((function(e, t) {
                var i = $(this).data("percentage");
                $(this).css("width", i + "%"), $(this).prop("Counter", 0).animate({
                    Counter: $(this).data("percentage")
                }, {
                    duration: 2e3,
                    easing: "swing",
                    step: function(e) {
                        $(this).text(Math.ceil(e))
                    }
                })
            })) : $(this).each((function(e, t) {
                $(this).css("width", 0)
            }))
        })), $(".piesite").each((function() {
            var e = $(this).offset().top;
            d + i > e || t > e ? 0 == piesiteFired && (timerSeconds = 3, timerFinish = (new Date).getTime() + 1e3 * timerSeconds, $(".piesite").each((function(e) {
                pie = $("#pie_" + e).data("pie"), timer = setInterval("stoppie(" + e + ", " + pie + ")", 0)
            })), piesiteFired = 1) : $(".piesite").each((function() {
                piesiteFired = 0
            }))
        }))
    }
    e.on("scroll", d), d()
})), setTimeout("end_session()", 1e6), $("#reset_notification").on("click", (function() {
    $.ajax({
        url: "ajax_call.php?page=reset_notification"
    }).done((function(e) {
        $("#reset_notification").html('Notification reset done <i class="far fa-check-circle"></i>')
    }))
})), $(".cs").on("change", (function() {
    chk = this.value, $.isNumeric(chk) && $(this).parent("form").submit()
})), window.history.replaceState && window.history.replaceState(null, null, window.location.href), $(".clientAddTbl_all_users").on("change", (function() {
    var e = $("#clientAddTbl_all_users").val();
    "all" == e ? $("tbody tr").show() : $("tbody tr").hide(), $("tbody tr:contains(" + e + ")").show()
})), $("#searchIsissue_serviceskywd").bind("keyup change", (function() {
    var e = $("#searchIsissue_serviceskywd").val();
    console.log(e), $("tbody tr").hide(), $("tbody tr:contains(" + e + ")").show()
})), $("#chkDuplicateEmail").on("change", (function() {
    var e = document.getElementById("chkDuplicateEmail").value;
    $.ajax({
        url: "ajax_call.php?page=chkDuplicateEmail",
        type: "post",
        data: {
            chkDuplicateEmail: e
        }
    }).done((function(e) {
        console.log(e), 1 == e ? (document.getElementById("signup_btn").disabled = !0, $("#chkDuplicateEmailTXT").html("Email already exists !")) : ($("#chkDuplicateEmailTXT").html(""), document.getElementById("signup_btn").disabled = !1)
    }))
}));

function insertRoomsEDIT(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("insertRoomsEDIT.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}

function viewSafeguarding(e) {
    $(".myevents-form").empty(), $(".myevents-div").removeClass("orangeborder"), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-form").load("safeguardingview.php?a?"+(Math.floor(Math.random() * (999 - 99)) + 99 )+"&id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}

function changeStatusSafeguard(e) {
    secure_delete("Are You Sure You Want To Change Status ?") && (console.log(e), $.ajax({
        type: "POST",
        url: "ajax_call.php?page=changeStatusSafeguard",
        data: "value=" + e
    }).done((function(e) {
        console.log(e), location.replace("Safeguarding_Form")
    })))
}
function changeUserDoc(e) {
    secure_delete("Are You Sure You Want To Disable Document ?") && (console.log(e), $.ajax({
        type: "POST",
        url: "ajax_call.php?page=changeUserDoc",
        data: "value=" + e
    }).done((function(e) {
        console.log(e),location.reload();
    })))
}
function changeStatusMockPlan(e) {
    secure_delete("Are You Sure You Want To Change Status ?") && (console.log(e), $.ajax({
        type: "POST",
        url: "ajax_call.php?page=changeStatusMockPlan",
        data: "value=" + e
    }).done((function(e) {
        console.log(e), location.replace("mock_inspection#tabs-3")
    })))
}
function remindernotification(e) {
    secure_delete("Are You Sure You Want To Send Reminder?") && (console.log(e), $.ajax({
        type: "POST",
        url: "ajax_call.php?page=remindernotification",
        data: "value=" + e
    }).done((function(e) {
        console.log(e)
    })))
}
function EditLabReport(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("Editlab.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}
function viewCommunication(e) {
    $(".myevents-form").empty(), $(".myevents-div").removeClass("orangeborder"), $(".myevents-div").addClass("myevents-div_"), $(".fixed_side").addClass("fixed_side_"), $(".myevents-form").load("viewCommunication.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    }))
}
$(".upgrade-btn_popup").click(function(){
  $(".upgrade-form").fadeIn();
  $(".fixed_side").addClass("fixed_side_");
});
$(".upgrade-btn").click(function(){
    $(this).fadeOut();
  $(".consult-box").fadeIn();
});
$(".cross").click(function(){
  $(".consult-box").fadeOut(); 
  $(".upgrade-btn").fadeIn();
});
function upgradePackage(e) {
    secure_delete("Are You Sure You Want To Upagde your Package ?") && (console.log(e), $.ajax({
        type: "POST",
        url: "ajax_call.php?page=upgradePackage",
        data: "value=" + e
    }).done((function(e) {
        console.log(e),location.reload();   
    })))
}
function insertGroupEDIT(e) {
    $(".myevents-form").empty(), $(".fixed_side").toggleClass("fixed_side_"), $(".myevents-div").toggleClass("myevents-div_"), $(".myevents-form").load("insertGroupEDIT.php?id=" + e, (function() {
        $(".myevents-div #loader").fadeOut(600), $(".background_side").fadeOut(600)
    })), $("[title='chat widget']").parent("div").hide()
}
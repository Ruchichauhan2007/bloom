var insulin_items = ["NovoLog", "Apidra", "Humalog", "Humulin R", "Novolin R", "Humulin N", "Novolin N", "Levemir", "Lantus"];
var available_insulin_items = ["NovoLog", "Apidra", "Humalog", "Humulin R", "Novolin R", "Humulin N", "Novolin N", "Levemir", "Lantus"];
var patientVitalLog = null;
var finished_init = false;

$(document).ready(function() {
    getPatientVitalsLogByVitalId(vitalId);
    switch (loggingPage) {
        case 1:
            setupPageOne();
            break;
        case 2:
            setupPageTwo();
            break;
    }

    if (entityType.toUpperCase() == "PATIENT") {
        $('.limited-input').on('keydown', function(event) {
        if (($(this).val().length > 4 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode != 190 && event.keyCode != 110)
             {   console.log("keyCode1:"+event.which);
				return false;
				}
        });
      $('.insulin-input').on('keydown', function(event) {
        var num =$(this).val();
		var digits = num.toString().split('');
		var LengthOfValue=$(this).val().length;
        if (digits[0] == "." || digits[0] == undefined && LengthOfValue == 0 ) {
		$(this).attr("maxlength","3");
        }
        else if (digits[1] == "."  || digits[1] == undefined  && LengthOfValue == 1 ) {
		$(this).attr("maxlength","4");
        }
        else if (digits[2] == undefined  && LengthOfValue == 2 ) {
		$(this).attr("maxlength","5");
		if (event.which != 8 && event.which != 9 && event.keyCode != 190 && event.keyCode != 110)
          { console.log("keyCode2:"+event.which); return false;}
        }
        else if (digits[3] == "."  && LengthOfValue == 2 ) {
		if ((event.which != 8) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && event.which != 9 && (event.keyCode < 96 || event.keyCode > 105))
          {console.log("keyCode3:"+event.which); return false;}
        }
      });

        $('.carb-input').on('keydown', function(event) {
        if (($(this).val().length > 1 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
              { console.log("keyCode4:"+event.which); return false;}
        });
		
		
        $('.not-so-limited-input').on('keydown', function(event) {
            if (($(this).val().length >= 800 && event.which != 8))
                return false;
        });
    } else {
        $('.limited-input').on('keydown', function(event) {
            return false;
        });
        $('.not-so-limited-input').on('keydown', function(event) {
            return false;
        });
    }
});

function getPatientVitalsLogByVitalId(id) {
    var arr = new Array();
    arr[0] = id;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'getPatientVitalsLogByVitalId', processResponse);
}

function processResponse(result) {
    if (result != null && result.message != null && result.success == true) {
        patientVitalLog = JSON.parse(result.message);

        initFields();
    }
}

function initFields() {
    if (!finished_init) {
        setTimeout(initFields, 50);
        return;
    }
    if (patientVitalLog != null && loggingPage == 1) {
        $(".carb-input").val(patientVitalLog.carbs);
        $("#mood-input").val(patientVitalLog.mood);
        $("#activity-input").val(patientVitalLog.activity);
        $("#feel-input").val(patientVitalLog.health);
        initInsulin(patientVitalLog.patientInsulinInfos);
    } else if (patientVitalLog != null && loggingPage == 2) {
        $("#message_box").val(patientVitalLog.Notes);
        $(".carb-input").val(patientVitalLog.bloodKeetone);

        var urine_input = patientVitalLog.urineKetone;
        $("input[name=urine_ketone]").each(function(index, element) {
            if ($(element).val() == urine_input) {
                $(element).prop("checked", true);
				var  spanId=$(element).val();
                if(spanId==5)
                {
                spanId=1;
                }
                else if(spanId==15)
                {
                                spanId=2;

                }
                else if(spanId==40)
                {
                                spanId=3;

                }
                else if(spanId==80)
                {
                                spanId=4;
                }
                else if(spanId==160)
                {
                                spanId=5;

                }

                $("#span"+spanId).addClass("spanCss");
                //console.log(spanId);
				
            }
        });
    }
}
 $(function(){
  $('input[type="radio"]').click(function(){
  $('span').removeClass("spanCss");
                var spanId = $(this).val();
                if(spanId==5)
                {
                spanId=1;
                }
                else if(spanId==15)
                {
                                spanId=2;

                }
                else if(spanId==40)
                {
                                spanId=3;

                }
                else if(spanId==80)
                {
                                spanId=4;
                }
                else if(spanId==160)
                {
                                spanId=5;

                }

                $("#span"+spanId).addClass("spanCss");
                //console.log(spanId);

  });
});

function initInsulin(vitalLogInsulin) {

    for( var i = 0; i < vitalLogInsulin.length -1; ++i) {
        $("#add-button").click();
    }

    var insulinItems = $(".insulin-item");
    for( var i = 0; i < vitalLogInsulin.length; ++i) {
        $(insulinItems[i]).find("input").val(vitalLogInsulin[i].insulinQty);
        $(insulinItems[i]).find("select").val(vitalLogInsulin[i].insulinType);
    }
}

function saveLogToServer() {
    if (entityType.toUpperCase() == "PATIENT") {
        if (patientVitalLog == null) {
            patientVitalLog = new Object();
            patientVitalLog.state = 1;
        } else {
            patientVitalLog.state = 2;
        }

        patientVitalLog.patientVitalId = vitalId;

        if (loggingPage == 1) {
            savePageOne();
        } else {
            savePageTwo();
        }

        var arr = new Array();
        arr[0] = JSON.stringify(patientVitalLog);
        var dataVal = JSON.stringify(arr);
        var retVal = postDataToServer(dataVal, EMR, 'createUpdatePatientVitalsLog', processSaveResponse);
    } else {
        processSaveResponse("result");
    }
}

function savePageOne() {
    var carb_input = $(".carb-input").val();
    if (carb_input != null && carb_input.trim() != "") {
        patientVitalLog.carbs = parseInt(carb_input);
    }

    var mood_input = $("#mood-input").val();
    if (mood_input != null && mood_input.trim() != "") {
        patientVitalLog.mood = parseInt(mood_input);
    }

    var activity_input = $("#activity-input").val();
    if (activity_input != null && activity_input.trim() != "") {
        patientVitalLog.activity = parseInt(activity_input);
    }

    var feel_input = $("#feel-input").val();
    if (feel_input == 0 || feel_input == 100) {
        patientVitalLog.health = parseInt(feel_input);
    }

    var insulin_to_save = new Array();

    var iter = 0;

    $(".insulin-item").each(function(index) {
        var currentItem = $(this).find("select").val();
        var currentValue = $(this).find("input").val();

        if (currentValue.trim() != "") {
            var currentInsulin = new Object();
            currentInsulin.insulinType = currentItem;
            currentInsulin.insulinQty = parseFloat(currentValue);
            currentInsulin.patientVitalId = vitalId;
            if (patientVitalLog.patientInsulinInfos != null && patientVitalLog.patientInsulinInfos.length > iter) {
                patientVitalLog.patientInsulinInfos[iter].state = 2;
                patientVitalLog.patientInsulinInfos[iter].insulinType = currentInsulin.insulinType;
                patientVitalLog.patientInsulinInfos[iter].insulinQty = currentInsulin.insulinQty;
            } else {
                currentInsulin.state = 1;
                insulin_to_save.push(currentInsulin);
            }
        }
        iter++;
    });
    if (insulin_to_save.length > 0) {
        patientVitalLog.patientInsulinInfos = insulin_to_save;
    }
}

function savePageTwo() {
    var blood_input = $(".carb-input").val();
    if (blood_input != null && blood_input.trim() != "") {
        patientVitalLog.bloodKeetone = parseInt(blood_input);
    }

    var urine_input = $("input[name=urine_ketone]:checked").val();
    if (urine_input != null && urine_input.trim() != "") {
        patientVitalLog.urineKetone = parseInt(urine_input);
    }

    var note_input = $(".new-note-input").val();
    if (note_input != null) {
        patientVitalLog.Notes = note_input;
    }
}

function processSaveResponse(result) {
    if (loggingPage == 1) {
        openPageWithAjax('../../vitals/pages/vitals_logging.php?vitalId=' + vitalId + '&loggingPage=2&vitalVal=' + vitalVal + '&vitalTime=' + vitalTime, '', 'menu-content', undefined, undefined);
    }
}

function setupPageOne() {

    var carbs_content = $("#section-one");
    setupCarbs(carbs_content);

    var insulin_content = $("#section-two");
    setupInsulin(insulin_content);

    var wellness_content = $("#section-three");
    setupWellness(wellness_content);

    if (entityType.toUpperCase() != "PATIENT") {
        $("input").attr("disabled", "");
    }

    var button_content = $("#topbar");
    setupButtons(button_content, 1);

    finished_init = true;
}

function setupCarbs(carbs_content) {
    var header = carbs_content.find(".header");
    header.find("h1").text("Carbs");
    header.find("img").attr("src", "/gladstone/portal/bloom/vitals/images/carbs_icon.png");

    var carbs_container = $("<div>")
        .attr("class", "logging-container-carbs")
        .appendTo(carbs_content);
    $("<input>")
        .attr("type", "text")
        .attr("class", "carb-input limited-input")
        .appendTo(carbs_container);
    $("<h3>")
        .text("grams")
        .attr("class", "logging-label center")
        .appendTo(carbs_container);
}

function setupInsulin(insulin_content) {
    var header = insulin_content.find(".header");
    header.find("h1").text("Insulin");
    header.find("img").attr("src", "/gladstone/portal/bloom/vitals/images/insulin_icon.png");

    if (entityType.toUpperCase() == "PATIENT") {
        $("<input>")
            .attr("type", "submit")
            .attr("value", "+ Add")
            .css("font-size", "20px")
            .css("margin", "0px 0px 0px 55px")
            .css("height", "36px")
            .css("width", "80px")
            .css("vertical-align", "top")
            .attr("id", "add-button")
            .on("click", addInsulinItem)
            .appendTo(insulin_content)
            .click();
    } else {
        $("<input>")
            .attr("type", "submit")
            .attr("value", "+ Add")
            .css("font-size", "20px")
            .css("margin", "0px 0px 0px 55px")
            .css("height", "36px")
            .css("width", "80px")
            .css("vertical-align", "top")
            .attr("id", "add-button")
            .css("display", "none")
            .on("click", addInsulinItem)
            .appendTo(insulin_content)
            .click();
    }
}

function setupWellness(wellness_content) {
    var header = wellness_content.find(".header");
    header.find("h1").text("Wellness");
    header.find("img").attr("src", "/gladstone/portal/bloom/vitals/images/wellness_icon.png");

    $("<h2>")
        .text("Mood")
        .attr("class", "logging-header")
        .appendTo(wellness_content);
    $("<input>")
        .attr("id", "mood-input")
        .attr("type", "range")
        .attr("min", "0")
        .attr("max", "100")
        .attr("step", "1")
        .appendTo(wellness_content);
    var mood_labels = $("<div>")
        .attr("class", "logging-label-container")
        .appendTo(wellness_content);
    $("<h3>")
        .text("Down")
        .attr("class", "logging-label left wellness")
        .appendTo(mood_labels);
    $("<h3>")
        .text("Happy")
        .attr("class", "logging-label right wellness")
        .appendTo(mood_labels);

    $("<h2>")
        .text("Activity")
        .attr("class", "logging-header")
        .appendTo(wellness_content);
    $("<input>")
        .attr("id", "activity-input")
        .attr("type", "range")
        .attr("min", "0")
        .attr("max", "100")
        .attr("step", "1")
        .appendTo(wellness_content);

    var activity_labels = $("<div>")
        .attr("class", "logging-label-container")
        .appendTo(wellness_content);
    $("<h3>")
        .text("Down")
        .attr("class", "logging-label left wellness")
        .appendTo(activity_labels);
    $("<h3>")
        .text("Up")
        .attr("class", "logging-label right wellness")
        .appendTo(activity_labels);

    $("<h2>")
        .text("How do you feel?")
        .attr("class", "logging-header")
        .appendTo(wellness_content);
    $("<input>")
        .attr("id", "feel-input")
        .attr("type", "range")
        .attr("min", "0")
        .attr("max", "100")
        .attr("step", "100")
        .appendTo(wellness_content);
    var health_labels = $("<div>")
        .attr("class", "logging-label-container")
        .appendTo(wellness_content);
    $("<h3>")
        .text("Sick")
        .attr("class", "logging-label left wellness")
        .appendTo(health_labels);
    $("<h3>")
        .text("Healthy")
        .attr("class", "logging-label right wellness")
        .appendTo(health_labels);
}

function setupPageTwo() {
    var urine_content = $("#section-one");
    setupUrine(urine_content);

    var blood_content = $("#section-two");
    setupBlood(blood_content);

    var note_content = $("#section-three");
    setupNote(note_content);

    if (entityType.toUpperCase() != "PATIENT") {
        $("input").attr("disabled", "");
    }

    var button_content = $("#topbar");
    setupButtons(button_content, 2);

    finished_init = true;
}

function setupUrine(urine_content) {
    var header = urine_content.find(".header");
    header.find("h1").text("Urine Ketone");
    header.find("img").attr("src", "/gladstone/portal/bloom/vitals/images/ketone_icon.png");

    var container = $("<div>")
        .attr("class", "ketone-radio-container")
        .appendTo(urine_content);

    $("<h3>")
        .attr("class", "logging-label")
        .text("mg/dL")
        .appendTo(container);

    for (var i = 0; i < 6; ++i) {
        var html;
        switch (i) {
            case 0:
                html = 0;
                break;
            case 1:
                html = 5;
                break;
            case 2:
                html = 15;
                break;
            case 3:
                html = 40;
                break;
            case 4:
                html = 80;
                break;
            case 5:
                html = 160;
                break;
        }
        $("<br><br>")
            .appendTo(container);

        $("<input>")
            .attr("type", "radio")
            .attr("class", "ketone")
            .attr("id", "option" + i)
            .attr("value", html)
            .attr("name", "urine_ketone")
            .appendTo(container);
        var label = $("<label>")
            .attr("for", "option" + i)
            .appendTo(container);

        $("<span>")
            .append("<span>")
			.attr("id", "span" + i)
            .appendTo(label);
        label.append("" + html);
    }
}

function setupBlood(blood_content) {
    var header = blood_content.find(".header");
    header.find("h1").text("Blood Ketone");
    header.find("img").attr("src", "/gladstone/portal/bloom/vitals/images/ketone_icon.png");

    var blood_container = $("<div>")
        .attr("class", "logging-container-carbs")
        .appendTo(blood_content);
    $("<input>")
        .attr("type", "text")
        .attr("class", "carb-input limited-input")
        .appendTo(blood_container);
    $("<h3>")
        .text("mmol/L")
        .attr("class", "logging-label center")
        .appendTo(blood_container);
}

function setupNote(note_content) {
    var header = note_content.find(".header");
    header.find("h1").text("Notes");
    header.find("img").attr("src", "/gladstone/portal/bloom/vitals/images/notes_icon.png");

    $("<textarea>")
        .attr("class", 'new-note-input not-so-limited-input')
        .on("keyup", function(event) {
            var length_box = $(event.target).val().length;
            if (length_box >= 800) {
                $("#light").hide();
                showPop();
                $("#txt").html("Over content limit.")

            }
        })
        .attr("maxlength", '800')
        .attr("id", "message_box")
        .appendTo(note_content);
}

function addInsulinItem(event) {
    if ($(".insulin-item").length < 6) {
        var insulin_content = $(event.target).parents(".section");
		if ($(".insulin-item").length > 2) {
		var whiteDivHeight= $("#whiteDiv").height();
		whiteDivHeight=whiteDivHeight+200;
		$("#whiteDiv").height(whiteDivHeight);
	}

        var content_container = $("<div>")
            .attr("class", "insulin-item")
            .appendTo(insulin_content);

        var insulin_select = $("<select>")
            .css("margin-bottom", "10px")
            .css("width", "200px")
            .on("change", checkInsulinItems)
            .appendTo(content_container);
        $("<input>")
            .attr("type", "text")
            .attr("class", "insulin-input limited-input")
            .appendTo(content_container);
        $("<h3>")
            .text("mg/dL")
            .attr("class", "logging-label center ")
            .css("padding-top", "10px")
            .appendTo(content_container);

        available_insulin_items.forEach(function(element, index, array) {
            $("<option>")
                .html(element)
                .val(element)
                .appendTo(insulin_select);
        });
        available_insulin_items.shift();

        checkInsulinItems();

        if (entityType.toUpperCase() == "PATIENT") {
            $('.limited-input').on('keydown', function(event) {
        if (($(this).val().length > 5 && event.which != 8  && event.which != 9) || isNaN(String.fromCharCode(event.which))  && event.which != 9 && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode != 190 && event.keyCode != 110)
                    return false;
            });
			
      $('.insulin-input').on('keydown', function(event) {
        var num =$(this).val();
		var digits = num.toString().split('');
		var LengthOfValue=$(this).val().length;
        if (digits[0] == "." || digits[0] == undefined && LengthOfValue == 0 ) {
		$(this).attr("maxlength","3");
        }
        else if (digits[1] == "."  || digits[1] == undefined  && LengthOfValue == 1 ) {
		$(this).attr("maxlength","4");
        }
        else if (digits[2] == undefined  && LengthOfValue == 2 ) {
		$(this).attr("maxlength","5");
		if (event.which != 8  && event.which != 9 && event.keyCode != 190 && event.keyCode != 110)
           return false;
        }
        else if (digits[3] == "."  && LengthOfValue == 2 ) {
		if ((event.which != 8) || isNaN(String.fromCharCode(event.which)) && event.which != 9 && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
           return false;
        }
      });
        } else {
            $('.limited-input').on('keydown', function(event) {
                return false;
            });
        }
    }
}

function checkInsulinItems() {
    available_insulin_items = insulin_items.slice(0, insulin_items.length);

    $(".insulin-item > select").each(function(index) {
        var item_index = available_insulin_items.indexOf($(this).val());
        if (index > -1) {
            available_insulin_items.splice(item_index, 1);
        }
    });

    $(".insulin-item > select").each(function(index) {
        var currentItem = $(this).val();

        var current = $(this);

        current
            .find('option')
            .remove()
            .end();

        $("<option>")
            .html(currentItem)
            .val(currentItem)
            .appendTo(current);

        available_insulin_items.forEach(function(element, index, array) {
            $("<option>")
                .html(element)
                .val(element)
                .appendTo(current);
        });
    });
}

function setupButtons(button_content, page) {
    button_content.css("top", "30px");

    var headerContainer = $("<div>")
        .css("padding-top", "10px")
        .css("padding-left", "10px")
        .appendTo(button_content);

    $("<h2>")
        .html(vitalVal)
        .css("display", "inline")
        .css("margin-right", "3px")
        .appendTo(headerContainer);
    $("<h3>")
        .html(" mg/dL")
        .css("display", "inline")
        .css("margin-right", "20px")
        .appendTo(headerContainer);

    var time_content = $("<h4>")
        .html(vitalTime)
        .css("display", "inline")
        .appendTo(headerContainer);


    $("<input>")
        .attr("type", "button")
        .attr("value", "Cancel")
        .css("font-size", "20px")
        .css("margin", "0px 0px 20px 10px")
        .css("height", "40px")
        .css("width", "100px")
        .css("display", "inline")
        .css("vertical-align", "top")
        .on("click", function(event) {
            openPageWithAjax('../../vitals/pages/vitals_graph.php', '', 'menu-content', undefined, undefined);
        })
        .appendTo(time_content);

    if (page == 1) {
        $("<input>")
            .attr("type", "submit")
            .attr("value", "Next")
            .css("font-size", "20px")
            .css("margin", "0px 0px 20px 10px")
            .css("height", "40px")
            .css("width", "100px")
            .css("vertical-align", "top")
            .css("display", "inline")
            .on("click", function(event) {
                saveLogToServer();
            })
            .appendTo(time_content);
    } else {
        $("<input>")
            .attr("type", "submit")
            .attr("value", "Save")
            .css("font-size", "20px")
            .css("margin", "0px 0px 20px 15px")
            .css("height", "40px")
            .css("width", "100px")
            .css("display", "inline")
            .css("vertical-align", "top")
            .on("click", function(event) {
                saveLogToServer();
                openPageWithAjax('../../vitals/pages/vitals_graph.php', '', 'menu-content', undefined, undefined);
            })
            .appendTo(time_content);
    }
}

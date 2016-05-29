var INSERT = 1;
var authorizationToken = '';
var dataLoading = false;
var startPageNo = 0;
var endPageNo = 1;
//Buffer = recordsPerPage*pagesToDisplay
var pagesToDisplay = 2;
var recordsPerPage = 20;
var delExtraFromDown = 0;

$(document).ready(function () {

  var userType = getCookie("type");
  
  if(userType.toUpperCase() == "PATIENT") {
      $("#showNotesBtn").hide();
  } else {
  $("#showNotesBtn").html("Show Notes");
  }

  $('.scrollingBox').bind('scroll', function () {

    var scrollPosition = $(this).scrollTop() + $(this).outerHeight();
    var divTotalHeight = $(this)[0].scrollHeight
      + parseInt($(this).css('padding-top'), 10)
      + parseInt($(this).css('padding-bottom'), 10)
      + parseInt($(this).css('border-top-width'), 10)
      + parseInt($(this).css('border-bottom-width'), 10);
		
    if (scrollPosition + 10 > divTotalHeight) {
      console.log("Scrolled down " + startPageNo + " -> " + endPageNo);
	  
      populateStikyNotes(endPageNo, true);
	  //$(".newElement").remove();
    }
    if ($(".scrollingBox").scrollTop() == 0) {
      if (startPageNo <= 0) {
        return;
      }
      console.log("Scrolled up " + startPageNo + " -> " + endPageNo);
      populateStikyNotes(startPageNo, false);

    }
	  $(".note").each(function () {
					   
	$('[id="' + this.id+ '"]:gt(0)').remove();
	});
	
  });
  /*$(".para").each(function () {
					   
	$('[id="' + this.id+ '"]:gt(0)').remove();
	});
	
  });*/

  var firstTimeNotes = true;
  $("#showNotesBtn").click(function () {
    if($(".sidebarBox").is(":visible")) {
      $("#showNotesBtn").html("Show Notes");
    } else {
      $("#showNotesBtn").html("Hide Notes");
    }
    $(".sidebarBox").toggle("slide", { direction: 'right' });
    if(firstTimeNotes) {
      if (patId != '') {
        if (authorizationToken == '') {
          refreshAuthToken(function (token) {
            authorizationToken = token;
            populateStikyNotes(endPageNo, true);
          });
        } else {
          populateStikyNotes(endPageNo, true);
        }
      }
    }
    firstTimeNotes = false;
  });

  

  $(".addCmtBtn").click(function () {
    var newCmt = $(".addCmtBox textarea").val();
    var isPinned = $("#pinNewCmt").is(':checked');

    if (authorizationToken == '') {
      refreshAuthToken(function (token) {
        authorizationToken = token;
        insertStikyNote(newCmt, isPinned);
      });
    } else {
      insertStikyNote(newCmt, isPinned);
    }
  });

  $('#cmtTextArea').bind('input propertychange', function () {
    $(".addCmtBtn").attr("disabled", "true");
    $(".addCmtBtnIcon").attr("disabled", "true");
    $(".addCmtBtnIcon").css("background-image", "url(../images/addNoteDisabled.png) no-repeat;");
    $(".addCmtBtn").css("color", "rgb(203,203,203)");

    if (this.value.length) {
      $(".addCmtBtn").removeAttr("disabled");
      $(".addCmtBtnIcon").removeAttr("disabled");
      $(".addCmtBtnIcon").css("background-image", "url(../images/addNoteEnabled.png) no-repeat;");
      $(".addCmtBtn").css("color", "black");
    }
  });
  
  $("#NH_allTab").click(function() {
    // SHow all 
    $(".addCmtBox").show();
    $(".note").show();
    $(".history").show();
    
    $("#NH_allTab").addClass("active");
    $("#NH_notesTab").removeClass("active");
    $("#NH_histTab").removeClass("active");
  });
  $("#NH_notesTab").click(function() {
    // SHow notes
    $(".addCmtBox").show();
    $(".note").show();
    $(".history").hide();
     
    $("#NH_allTab").removeClass("active");
    $("#NH_notesTab").addClass("active");
    $("#NH_histTab").removeClass("active");
  });
  $("#NH_histTab").click(function() {
    // SHow history: 
    $(".addCmtBox").hide();
    $(".note").hide();
    $(".history").show();
    
    $("#NH_allTab").removeClass("active");
    $("#NH_notesTab").removeClass("active");
    $("#NH_histTab").addClass("active");
  });

});


// Utility methods: 
function insertStikyNote(cmt, isPinned) {
  var editUserIdVal = $("#currentUserId").val();

  if (typeof patId == "null" || patId == "" || isNaN(patId)) {
    patId = $("#currentUserId").val();
  }

  var stickyNoteInfo = {
    'editUserId': parseInt(editUserIdVal),
    'patientId': parseInt(patId),
    'userId': parseInt(editUserIdVal),
    'state': INSERT,
    'description': cmt,
    'pinned': isPinned,
    'noteType': "OBSERVATION",
    'chars': ''
  }

  $.ajax({
    type: 'POST',
    beforeSend: function (request) {
      request.setRequestHeader("Authorization", authorizationToken);
    },
    url: window.location.origin + "/gladstone/rest/emr/insertStickyNotes",
    data: stickyNoteInfo,
    statusCode: {
      401: function () {
        console.log("Invalid Token");
        refreshAuthToken(function (token) {
          authorizationToken = token;
          insertStikyNote(cmt, isPinned);
        });
      },
      200: function (data) {
		  
        addStickyNoteFirstTime(data);
        $(".addCmtBox textarea").val('');
        $("#pinNewCmt").removeAttr('checked');
        $(".addCmtBtn").attr("disabled", "true");
        $(".addCmtBtnIcon").attr("disabled", "true");
        $(".addCmtBtnIcon").css("background-image", "url(../images/addNoteDisabled.png) no-repeat;");
        $(".addCmtBtn").css("color", "rgb(203,203,203)");
      }
    }
  });
}

function populateStikyNotes(currentPageNo, isScrollDown) {
	
  if (currentPageNo == undefined) {
    currentPageNo = 1;
  }
  if (dataLoading) {	  
	 
    console.log("Data loading - ignoring req");
    return;
  }
  else
  {
	  console.log("else");
  }
  if (currentPageNo < endPageNo && currentPageNo > startPageNo) {
    // nothing load: no need to do backend call!
    console.log("not loading [" + startPageNo + " -> " + endPageNo + "]; current: " + currentPageNo);
    return;
  }

  dataLoading = true;
  console.log("populateStikyNotes -> page: " + currentPageNo);

  if (typeof patId == "null" || patId == "" || isNaN(patId)) {
    patId = $("#currentUserId").val();
  }
  var formData = {
    'patientId': patId,
    'type': "ALL",
    "currentPageNo": currentPageNo,
    "recordsPerPage": recordsPerPage
  };
  $.ajax({
    type: 'GET',
    beforeSend: function (request) {
      request.setRequestHeader("Authorization", authorizationToken);
    },
    url: window.location.origin + "/gladstone/rest/emr/getNotesAndHistory",
    data: formData,
    statusCode: {
      default: function () {
        console.log("Bad request");
        dataLoading = false;
      },
      401: function () {
        console.log("Invalid Token");
        refreshAuthToken(function (token) {
          authorizationToken = token;
          populateStikyNotes(currentPageNo, isScrollDown);
          dataLoading = false;
        });
      },
      200: function (data) {
		  console.log(data);
        if (data.length == 0) {
		
          dataLoading = false;
          console.log("reached end of the data");
          return;
        }
		
        for (i = 0; i < data.length; i++) {
          addNoteAndHistory(data[i]);
		  //$(".newElement").remove();
        }
        sortNotes("notesBox");
        sortNotes("pinnedNotes");
        dataLoading = false;
        if (endPageNo - startPageNo > pagesToDisplay) {
          // Delete the 1st recordsPerPage divs: 
          var cnt = 0;
          var pinnedDivs = $(".pinnedNotes").children();
          var noteDivs = $(".notesBox").children();
          var numDivsToRemove = recordsPerPage; //	totalNotes - pagesToDisplay*recordsPerPage;
          if (data.length < recordsPerPage) {
            // numDivsToRemove = recordsPerPage - ((pagesToDisplay+1)*recordsPerPage - totalNotes);
            numDivsToRemove = 0;
            delExtraFromDown = data.length;
          }
          if (numDivsToRemove > 0) {
            if (isScrollDown) {
              for (var i = 0; i < pinnedDivs.length; i++) {
                pinnedDivs[i].remove();
                cnt++;
                if (cnt == numDivsToRemove) {
                  break;
                }
              }

              for (var i = 0; i < noteDivs.length; i++) {
                if (cnt == numDivsToRemove) {
                  break;
                }
                noteDivs[i].remove();
				
                cnt++;
              }
              startPageNo++;
              $('.scrollingBox').scrollTop($('.scrollingBox').scrollTop() - 25);
            } else {
              for (var i = noteDivs.length - 1; i >= 0; i--) {
                noteDivs[i].remove();
                cnt++;
                if (cnt == delExtraFromDown + numDivsToRemove) {
					
					
                  break;
				  
                }
              }

              for (var i = pinnedDivs.length - 1; i >= 0; i--) {
                if (cnt == delExtraFromDown + numDivsToRemove) {
                  break;
                }
                pinnedDivs[i].remove();
                cnt++;
              }
              if (delExtraFromDown > 0) {
                delExtraFromDown = 0;
                endPageNo--;
              }

              endPageNo--;
              $('.scrollingBox').scrollTop(25);
            }
          }
        }
        if (isScrollDown) {
          endPageNo++;
        } else {
          startPageNo--;
        }
        console.log("New " + startPageNo + " -> " + endPageNo);
      }
    }
  })

	

}

function notePined(noteId, pinned) {
  var formData = {
    'stickyNotesId': noteId,
    'pinned': pinned
  };
  $.ajax({
    type: 'POST',
    beforeSend: function (request) {
      request.setRequestHeader("Authorization", authorizationToken);
    },
    url: window.location.origin + "/gladstone/rest/emr/updatePinStatus",
    data: formData,
    statusCode: {
      401: function () {
        console.log("Invalid Token");
        refreshAuthToken(function (token) {
          authorizationToken = token;
          notePined(noteId, pinned);
        });
      },
      200: function (data) {
        // Move it up: 
        var noteDiv = $("#note_" + noteId).parent().parent();
        var timeStamp = noteDiv.attr('data-sort');
        console.log("Time: " + timeStamp);
        var noteContent = "<div data-sort='" + timeStamp + "' class=\"note\" id='" + timeStamp + "'>" + noteDiv.html() + "</div>";
        noteDiv.remove();
        if (pinned == "true") {
          $(".pinnedNotes").prepend("\n" + noteContent);
          sortNotes("pinnedNotes");
          $("#note_" + noteId).prop('checked', true);
        } else {
          $(".notesBox").prepend("\n" + noteContent);
		  $(".newElement").remove();
          sortNotes("notesBox");
          $("#note_" + noteId).prop('checked', false);
        }

      }
    }
  });
}

function handleNotePined(noteId) {
  var pinned = 'false';
  if ($("#note_" + noteId).is(':checked')) {
    pinned = 'true';
  }

  notePined(noteId, pinned);
}
function addStickyNoteFirstTime(noteData)
{
	 var newCmt = noteData.description;
  if (newCmt == "") {
    newCmt = "&nbsp;";
  }
  var timeStamp = noteData.createTimeStamp;
  var timeStr = "";
  if (timeStamp == undefined) {
    timeStr = CURRENT_TIME;
  } else {
    timeStr = timeConverter(timeStamp);
  }
  var username = noteData.lastModifiedName;

  var pinedStr = (noteData.pinned != false) ? "checked=true" : "";
  var newNoteStr = "<div data-sort='" + timeStamp + "' class=\"note newElement\" id='" + timeStamp + "'><h5>" + username + " - " + timeStr + " - Note<input class='pinInput' style='float: right;margin-right: 5px;' " + pinedStr + " type='checkbox' id=\"note_" + noteData.stickyNotesId + "\" onclick=\"javascript:handleNotePined('" + noteData.stickyNotesId + "');\" /><label for=\"note_" + noteData.stickyNotesId + "\"></h5><p class='para' id='" + newCmt + "'>" + newCmt + "</p></div>";
  if (noteData.pinned != false) {
    $(".pinnedNotes").prepend("\n" + newNoteStr);
  } else {
    $(".notesBox").prepend("\n" + newNoteStr);
  }

}
function addStickyNote(noteData) {
  var newCmt = noteData.description;
  if (newCmt == "") {
    newCmt = "&nbsp;";
  }
  var timeStamp = noteData.createTimeStamp;
  var timeStr = "";
  if (timeStamp == undefined) {
    timeStr = CURRENT_TIME;
  } else {
    timeStr = timeConverter(timeStamp);
  }
  var username = noteData.lastModifiedName;

  var pinedStr = (noteData.pinned != false) ? "checked=true" : "";
  var newNoteStr = "<div data-sort='" + timeStamp + "' class=\"note\" id='" + timeStamp + "'><h5>" + username + " - " + timeStr + " - Note<input class='pinInput' style='float: right;margin-right: 5px;' " + pinedStr + " type='checkbox' id=\"note_" + noteData.stickyNotesId + "\" onclick=\"javascript:handleNotePined('" + noteData.stickyNotesId + "');\" /><label for=\"note_" + noteData.stickyNotesId + "\"></h5><p>" + newCmt + "</p></div>";
  if (noteData.pinned != false) {
    $(".pinnedNotes").prepend("\n" + newNoteStr);
  } else {
	  
    $(".notesBox").prepend("\n" + newNoteStr);
  }

}
function addHistory(dataChangeHeaderInfo) {
  var provFname = dataChangeHeaderInfo.provFirstName;
  var provLname = dataChangeHeaderInfo.provLastName;
  var timeStamp = dataChangeHeaderInfo.createTimeStamp;
  var timeStr = "";
  if (timeStamp == undefined) {
    timeStr = CURRENT_TIME;
  } else {
    timeStr = timeConverter(timeStamp);
  }

  var i = 0;
  var text = '';
  var actionType = 'Added';
  var histAction = 'Added';

  for (i = 0; i < dataChangeHeaderInfo.dataChangeDetailInfo.length; i++) {
    var eachDetail = dataChangeHeaderInfo.dataChangeDetailInfo[i];

    if (text != '') {
      text = text + "<br/>"
    }
    actionType = eachDetail.actionType;
	
	if(actionType == 'PATIENT_MODIFIED')
	{
		if(eachDetail.oldValue=='')
    {
      var histAction = "Added";
      text = text + eachDetail.fieldName + " - " +eachDetail.newValue;
    }
    else
    {
      var histAction = "Changed";
      text = text + eachDetail.fieldName + " Changed From " + eachDetail.oldValue + " To " + eachDetail.newValue;
    }
	}
	else
	{
		text = text + eachDetail.actionDescription;
	}
  }

  var newNoteStr = "<div data-sort='" + timeStamp + "' class=\"history\"><h5>" + provFname + " " + provLname + " - " + timeStr + " - "+ histAction + "</h5><p>" + text + "</p></div>"
  $(".notesBox").prepend("\n" + newNoteStr);
  
}

function sortNotes(parentClass) {
  var $wrapper = $('.' + parentClass);

  $wrapper.children().sort(function (a, b) {
									
    return +b.getAttribute('data-sort') - +a.getAttribute('data-sort');
  })
    .appendTo($wrapper);
}

function addNoteAndHistory(noteAndHistoryData) {
  if (noteAndHistoryData.objectType == "NOTES") {
    addStickyNote(noteAndHistoryData.stickyNote);
  }

  if (noteAndHistoryData.objectType == "HISTORY") {
    
    addHistory(noteAndHistoryData.dataChangeHeaderInfo);
  }
}

function timeConverter(UNIX_timestamp) {
  var a = new Date(UNIX_timestamp);
  var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  var month = months[a.getMonth()];
  var date = (a.getDate() < 10 ? '0' : '') + a.getDate();
  var hour = (a.getHours() < 10 ? '0' : '') + a.getHours();
  var min = (a.getMinutes() < 10 ? '0' : '') + a.getMinutes();
  var time = date + ' ' + month + ' ' + hour + ':' + min;
  return time;
}


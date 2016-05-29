var patVitalInfos;
var zoomDays;

// Get the vital info from the server
function getVitalsGraphData(id) {
    var vitalsFilterInfo = new Object();
    vitalsFilterInfo.patientId = id;
    vitalsFilterInfo.deviceConfigId = 1;

    var startDate = new Date();
    startDate.setDate(startDate.getDate() - 90);
    var dt = startDate.toISOString().replace('Z', '') + '-0000';

    var endDate = new Date();
    endDate.setDate(endDate.getDate() + 1);
    var edt = endDate.toISOString().replace('Z', '') + '-0000';

    vitalsFilterInfo.startDate = dt;
    vitalsFilterInfo.endDate = edt;

    var arr = new Array();
    arr[0] = JSON.stringify(vitalsFilterInfo);
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'getPatientVitalInfo', processResponse);
}

// Set the vital info using data from the server
function processResponse(result) {
    if (result != null && result.message != null && result.success == true) {
    	
        patVitalInfos = JSON.parse(result.message);
        for ( var ii = 0; ii < patVitalInfos.length; ii++) {
			var l_patVital = patVitalInfos[ii];
			if(l_patVital.unitValue1 > 600){
				l_patVital.unitValue1 = 625; 
			}
			if(l_patVital.unitValue1 < 20){
				l_patVital.unitValue1 = 19; 
			}
		}
        loadGraph();

        if (patVitalInfos.length > 0) {
            $("#7day").click();
        }
    }
}

// Get the meal schedule from the server
function getMealSchedule() {
    var arr = new Array();
    arr[0] = "GLUCOSE"
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'getMealSchedulesByVitalType', processMealSchedule);
}

// Show the mean schedule at the top of the graph
function processMealSchedule(result) {
    if (result != null && result.message != null && result.success == true) {
        var mealSchedule = JSON.parse(result.message);
        mealSchedule.forEach(function(element, index, array) {
            var startTime = element.startTime;
            var endTime = element.endTime;
            if (element.mealCategory == "BREAKFAST") {
                var labelText = "Breakfast ";
                if (parseInt(startTime) < 12 && parseInt(endTime) < 12) {
                    labelText += startTime + " - " + endTime + " am";
                } else if (parseInt(startTime) < 12) {
                    endTime = parseInt(endTime) - 12;
                    labelText += startTime + " am - " + endTime + " pm";
                } else {
                    startTime = parseInt(startTime) - 12;
                    endTime = parseInt(endTime) - 12;
                    labelText += startTime + " - " + endTime + " pm";
                }
                $("#breakfast-label").html(labelText);
            } else if (element.mealCategory == "LUNCH") {
                var labelText = "Lunch ";
                if (parseInt(startTime) < 12 && parseInt(endTime) < 12) {
                    labelText += startTime + " - " + endTime + " am";
                } else if (parseInt(startTime) < 12) {
                    endTime = parseInt(endTime) - 12;
                    labelText += startTime + " am - " + endTime + " pm";
                } else {
                    startTime = parseInt(startTime) - 12;
                    endTime = parseInt(endTime) - 12;
                    labelText += startTime + " - " + endTime + " pm";
                }
                $("#lunch-label").html(labelText);
            } else if (element.mealCategory == "DINNER") {
                var labelText = "Dinner ";
                if (parseInt(startTime) < 12 && parseInt(endTime) < 12) {
                    labelText += startTime + " - " + endTime + " am";
                } else if (parseInt(startTime) < 12) {
                    endTime = parseInt(endTime) - 12;
                    labelText += startTime + " am - " + endTime + " pm";
                } else {
                    startTime = parseInt(startTime) - 12;
                    endTime = parseInt(endTime) - 12;
                    labelText += startTime + " - " + endTime + " pm";
                }
                $("#dinner-label").html(labelText);
            } else if (element.mealCategory == "BED") {
                var labelText = "Bedtime ";
                if (parseInt(startTime) < 12 && parseInt(endTime) < 12) {
                    labelText += startTime + " - " + endTime + " am";
                } else if (parseInt(startTime) < 12) {
                    endTime = parseInt(endTime) - 12;
                    labelText += startTime + " am - " + endTime + " pm";
                } else if (parseInt(endTime) < 12) {
                    startTime = parseInt(startTime) - 12;
                    labelText += startTime + " pm - " + endTime + " am";
                } else {
                    startTime = parseInt(startTime) - 12;
                    endTime = parseInt(endTime) - 12;
                    labelText += startTime + " - " + endTime + " pm";
                }
                $("#bedtime-label").html(labelText);
            }
        });
    }
}

// Remove existing data for graph reloads
function clearGraph() {
    $(".graph-content").empty();
    div = d3.select(".graph-content")
    .append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);

}

// Filters the data based on pre/post meal and meal value
function getSegment(dataNest) {
    var segment = $("#segmentSelect").val();

    if (segment == "ALL") {
        return -1;
    }

    for (i = 0; i < dataNest.length; i++) {
    	console.log('dataNest : '+dataNest[i].key +' seg :'+segment)
        if (dataNest[i].key == segment) {
            return i;
        }
    }
}

// Check to see if the left arrow should show
function checkLeftDate(date) {
    var testDate = new Date();
    testDate.setDate(testDate.getDate() - zoomDays);

    return moment(date).isAfter(testDate, "days");
}

// Check to see if the right arrow should show
function checkRightDate(date) {
    var testDate = new Date();

    return moment(date).isBefore(testDate, "days");
}

// Filter the data based on the given daye
function sortValues(data, date) {
    var dataCopy = [];

    data.forEach(function(d) {
        if (formatTime(d.vitalTime) == date) {
            dataCopy.push(d);
        }
    });

    return dataCopy;
}

// Add the tooltip to the html page
var div = d3.select(".graph-content")
    .append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);

// Parse the date / time
var parseDate = d3.time.format("%Y-%m-%dT%H:%M:%S.%L%Z").parse;
var formatTime = d3.time.format("%m/%d/%y");
var formatTableTime = d3.time.format("%I:%M %p");


// Builds the table based on the date provided
// Parameters:
//      tooltip: The element to build the table in
//      allData: The patient vitals info to filter through
//      columns: An array of columns to display, to make expanding/reordering the table easier
//      date: The date to filter entries through
//      left: Whether or not to show the left arrow
//      right: Whether or not to show the right arrow
function tabulate(tooltip, allData, columns, date, left, right) {

    // Filter the data and clear the table
    tempData = sortValues(allData, formatTime(date));
    tooltip.selectAll("table").remove();
    tooltip.selectAll("div").remove();

    // Build the table's header
    var topTable = tooltip.append("table").attr("class", "toptable");
    var header = topTable.append("tr");
    if (left) {
        header.append("th")
            .html("<img src='../../vitals/images/PrevDay.png' style='height:25px;width:25px;'>")
            .style("width", "9%")
            .on("click", function() {
                var newDate = new Date(date.getTime());
                newDate.setDate(newDate.getDate() - 1);
                
                tabulate(tooltip, allData, columns, newDate, checkLeftDate(newDate), checkRightDate(newDate));
            });
    }
    header.append("th")
        .html(formatTime(date))
        .style("width", "20%")
        .style("font-size", "22px");
    header.append("th")
        .html("mg/dL")
        .style("width", "20%")
        .style("font-size", "22px");
    if (right) {
        header.append("th")
            .html("<img src='../../vitals/images/NextDay.png' style='height:25px;width:25px;'>")
            .style("width", "9%")
            .on("click", function() {
                var newDate = new Date(date.getTime());
                newDate.setDate(newDate.getDate() + 1);
                tabulate(tooltip, allData, columns, newDate, checkLeftDate(newDate), checkRightDate(newDate));
            });
    }
    header.append("th")
        .html("<img src='../../vitals/images/close.png' style='height:25px;width:25px;'>")
        .style("width", "9%")
        .on("click", function() {
            div.transition()
                .duration(200)
                .style("opacity", 0.0)
                .style("pointer-events", "none");
        });
    tooltip.append("div")
        .style("height", "5px");
    var body = tooltip.append("table").attr("class", "main-table");
    // Finish building the table

    // create a row for each object in the data
    var rows = body.selectAll("tr")
        .data(tempData)
        .enter()
        .append("tr")
        .on("click", function(event) {
            var formatUrlTime = d3.time.format("%B %-d, %Y %I:%M %p");
            var vitalId = event.patientVitalId;
            var vitalVal = event.unitValue1;
            var vitalTime = formatUrlTime(event.vitalTime);
            openPageWithAjax('../../vitals/pages/vitals_logging.php?vitalId=' + vitalId + '&loggingPage=1&vitalVal=' + vitalVal + '&vitalTime=' + vitalTime, '', 'menu-content', undefined, undefined);
        })
        .attr("class", "table-row")
        .style("font-size", "20px")
        .style("border-spacing", "5px");

    // create a cell in each row for each column
    var cells = rows.selectAll("td").data(function(row) {
            return columns.map(function(column) {
                if (column == "vitalTime") {
                    // The vital time needs a column title and the date value
                	//var date = new Date(row[column].toISOString());
                	//var offsetTime = new Date(date.getTime() - date.getTimezoneOffset() * 60 * 1000);
                    return {
                        column: column,
                        value: formatTableTime(row[column])
                    };
                } else if (column == "id") {
                    // The id needs a column title and the id value
                    return {
                        column: column,
                        value: row.patientVitalId
                    };
                } else if (column == "space") {
                    // Spaces don't need anything
                    return " ";
                } else if (column == "additionalInformation") {
                    // The additional information needs a column title and a true/false value
                    return {
                        column: column,
                        value: row["additionalInformation"]
                    }
                } else {
                    // The vital value need a column title, vital value, and whether or not the value was taken manually
                    return {
                        column: column,
                        value: row[column],
                        manual: row["observationMode"]
                    };
                }
            });
        })
        .enter()
        .append("td")
        .attr("class", function(d) {
            // If the column is contains a vital value, change tha background based on in/out of range
            if (d.column == "unitValue1") {
                if (parseFloat(d.value) >= tempData[0].deviceMaxValue || parseFloat(d.value) <= tempData[0].deviceMinValue) {
                    return "glucose-table-item extreme";
                } else if (parseFloat(d.value) > tempData[0].minUnitValue1 && parseFloat(d.value) <= tempData[0].maxUnitValue2) {
                    return "glucose-table-item inrange";
                }
                else if ((parseFloat(d.value) > tempData[0].deviceMinValue && parseFloat(d.value) <= tempData[0].minUnitValue1)  || (parseFloat(d.value) > tempData[0].maxUnitValue2 && parseFloat(d.value) <= tempData[0].deviceMaxValue)) {
                    return "glucose-table-item danger";
                }				else {
                    return "glucose-table-item yellow";
                }
            } else if (d == " ") {
                return "glucose-table-item";
            } else if (d.column == "id") {
                return "id";
            } else {
                return "glucose-table-item normal";
            }
        }).attr("style", "font-family: Courier") // sets the font style
        .style("width", function(d) {
            // Change the column width based on the column
            if (d == " ") {
                return "5%";
            } else if (d.column == "additionalInformation") {
                return "10%";
            } else {
                return "30%";
            }
        })
        .style("display", function(d) {
            // Change the display to hide the vital id
            if (d != " ") {
                if (d.column == "id") {
                    return "none";
                }
            }
            if (d != " " && d.column == "id") {
                return "gone";
            } else {
                return "visible";
            }
        })
        .html(function(d) {
            // Set the value of the cell based on the column
            var val = d.value;
            if (val > 600) {
                val = "HI";
            }
            if (val < 20) {
                val = "LO";
            }
            if (d.manual == "PAT_TAKEN_MANUAL") {
                val += "*";
            }
            if (d.column == "additionalInformation") {
                if (d.value == false) {
                    val = "<img src='../../vitals/images/pencil_empty.png' style='height:30px;width:30px;'>";
                } else {
                    val = "<img src='../../vitals/images/pencil_filled.png' style='height:30px;width:30px;'>";
                }
            }
            return val;
        });

    // Dynamically change the height and width to hold all of the data
    tooltip.style("height", parseInt(body.style("height")) + parseInt(topTable.style("height")) + 10);
    body.style("width", tooltip.style("width"));
    topTable.style("width", tooltip.style("width"));
}

// Construct the x-axis
function make_x_axis() {
    return d3.svg.axis()
        .scale(x)
        .orient("bottom")
        .ticks(5)
}

// Construct the y-axis
function make_y_axis() {
    return d3.svg.axis()
        .scale(y)
        .orient("left")
        .ticks(5)
}

// The margins for the graph
var margin = {
    top: 30,
    right: 30,
    bottom: 30,
    left: 50
};

// Loads the graph
function loadGraph() {
    var data = patVitalInfos;

    var xAxis = d3.svg.axis().scale(x).orient("bottom").ticks(5);

    var yAxis = d3.svg.axis().scale(y).orient("left").ticks(5);

    var d = new Date();
    d.setDate(d.getDate() - zoomDays);

    var i = 0;

    // Sets the svg element up and adds boundaries to it's drawing
    var svg = d3.select(".graph-content")
        .append("svg")
        .attr("id", "graph")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    var clip = svg.append("defs")
        .append("svg:clipPath")
        .attr("id", "clip")
        .append("svg:rect")
        .attr("id", "clip-rect")
        .attr("x", "0")
        .attr("y", "0")
        .attr("width", width)
        .attr("height", height);

    var chartBody = svg.append("g")
        .attr("clip-path", "url(#clip)");

    var rect = chartBody.append('svg:rect')
        .attr('width', width)
        .attr('height', height)
        .attr('fill', '#FFF');

    // Shows the y-axis label
    svg.append("text")
        .attr("class", "y label")
        .attr("text-anchor", "end")
        .attr("y", -30)
        .attr("x", 5)
        .attr("dy", ".75em")
        .text("mg/dL");

    // Tells D3 how to handle each data point
    var valueline = d3.svg.line().x(function(d) {
        return x(d.vitalTime);
    }).y(function(d) {
        return y(d.unitValue1);
    });

    // Sets up the graph y-limits
    var ymin = data[0].deviceMinValue;
    var ymax = data[0].deviceMaxValue+50; // change graph height

    // Formats the vital info dates
    data.forEach(function(d, i) {
        if (typeof d.vitalTime == 'string') {
            d.vitalTime = parseDate(d.vitalTime);
            console.log('vital Time befor : '+d.vitalTime);
//           var date = new Date(d.vitalTime);
//           var offsetTime = new Date(date.getTime() - date.getTimezoneOffset() * 60 * 1000);	
           //d.vitalTime = offsetTime;
           console.log('vital Time after : '+d.vitalTime);
        }
    });
    var endDate = new Date();
    endDate.setHours(23);
    endDate.setMinutes(59);
    endDate.setSeconds(59);
    // Sets the graph x- and y-limits based on the days to zoom and device limits
    x.domain([d, endDate]);
    y.domain([ymin - 3, ymax + 3]);

    // Splits the data into multiple segments based on meal time and pre/post meal
    var dataNest = d3.nest()
        .key(function(d) {
            if (d.mealCategory == "BED") {
                return "SLEEP";
            }
            if (d.mealType == "UNSPECIFIED") {
                return "UNSPECIFIED";
            }
            return d.mealCategory + d.mealType;
        })
        .entries(data);
  /*console.log(data[0].graphDisplayRangeInfos[0]);
  console.log(data[0].graphDisplayRangeInfos[1]);
  console.log(data[0].graphDisplayRangeInfos[2]);
  console.log(data[0].graphDisplayRangeInfos[3]);*/
    // Adds in the yellow and green areas to the graph
    var rectheight = y(data[0].graphDisplayRangeInfos[0].upperRange) - y(data[0].graphDisplayRangeInfos[0].lowerRange);
    var recty = y(data[0].graphDisplayRangeInfos[0].upperRange);
	var yellowClass = data[0].graphDisplayRangeInfos[0].color.split(" ").join("");
    var rectangle = chartBody.append("rect")
        .attr("x", 0)
        .attr("y", recty)
        .attr("width", width)
        .attr("height", -rectheight)
        .attr('class', yellowClass);
     var rectheight = y(data[0].graphDisplayRangeInfos[1].upperRange) - y(data[0].graphDisplayRangeInfos[1].lowerRange);
    var recty = y(data[0].graphDisplayRangeInfos[1].upperRange);
	var lightGreenClass = data[0].graphDisplayRangeInfos[1].color.split(" ").join("");
    var rectangle = chartBody.append("rect")
        .attr("x", 0)
        .attr("y", recty)
        .attr("width", width)
        .attr("height", -rectheight)
        .attr('class', lightGreenClass);
     var rectheight = y(data[0].graphDisplayRangeInfos[2].upperRange) - y(data[0].graphDisplayRangeInfos[2].lowerRange);
    var recty = y(data[0].graphDisplayRangeInfos[2].upperRange);
	var darkGreenClass = data[0].graphDisplayRangeInfos[2].color.split(" ").join("");
    var rectangle = chartBody.append("rect")
        .attr("x", 0)
        .attr("y", recty)
        .attr("width", width)
        .attr("height", -rectheight)
        .attr('class', darkGreenClass);
		  var rectheight = y(data[0].graphDisplayRangeInfos[3].upperRange) - y(data[0].graphDisplayRangeInfos[3].lowerRange);
    var recty = y(data[0].graphDisplayRangeInfos[3].upperRange);
	var yellowClass = data[0].graphDisplayRangeInfos[3].color.split(" ").join("");
    var rectangle = chartBody.append("rect")
        .attr("x", 0)
        .attr("y", recty)
        .attr("width", width)
        .attr("height", -rectheight)
        .attr('class', yellowClass);

    svg.append("g") // Add the X Axis
        .attr("class", "x axis")
        .attr("transform", "translate(0," + (height + 2) + ")")
        .call(xAxis);

    svg.append("g") // Add the Y Axis
        .attr("class", "y axis")
        .attr("transform", "translate(-2,0)")
        .call(yAxis);

    legendSpace = width / dataNest.length; // spacing for the legend

    // Gets the segment to display and checks for the "all" segment
    var segment = getSegment(dataNest);
    console.log('dataNest[segment] : '+segment)
    if (segment == -1) {
        dataNest[0].values = patVitalInfos;
        dataNest[0].key = "ALL";

        segment = 0;
    }

    // Checks to make sure the data set is not empty
    if (!(typeof(dataNest[segment]) == "undefined")) {
    	
        chartBody.append("g")
            .attr("class", "grid")
            .attr("transform", "translate(0," + height + ")")
            .call(make_x_axis()
                .tickSize(-height, 0, 0)
                .tickFormat("")
            );

        chartBody.append("g")
            .attr("class", "grid")
            .call(make_y_axis()
                .tickSize(-width, 0, 0)
                .tickFormat("")
            );

        // Adds the graph line using the segment's values
        chartBody.append("path")
            .attr("class", "line")
            .style("stroke", function() { // Add the colours dynamically
                return d.color = "#000000";
            })
            .attr("id", 'tag' + dataNest[segment].key.replace(/\s+/g, '')) // assign ID
            .attr("d", valueline(dataNest[segment].values));

        // Adds in dots for each value
        chartBody.selectAll("dot")
            .data(dataNest[segment].values)
            .enter().append("circle")
            .attr("r", 7).attr("fill", function(d) {
                if (d.unitValue1 >= d.deviceMaxValue || d.unitValue1 <= d.deviceMinValue) {
                    return "#000";
                } else if (d.unitValue1 > d.minUnitValue1 && d.unitValue1 <= d.maxUnitValue2) {
                    return "#000";
                } else if ((d.unitValue1 > d.deviceMinValue && d.unitValue1 <= d.minUnitValue1) ||
					(d.unitValue1 > d.maxUnitValue2 && d.unitValue1 <= d.deviceMaxValue)) {
                    return "#000";
                } else {
                    return "#000";
                }
            })
            .attr("opactity", 1.0)
            .attr("cx", function(d) {
                return x(d.vitalTime);
            })
            .attr("cy", function(d) {
                return y(d.unitValue1);
            });

        // Adds a bigger click area for each dot
        chartBody.selectAll("dot")
            .data(dataNest[segment].values)
            .enter()
            .append("circle")
            .attr("r", 12)
            .attr("opacity", 0.0)
            .attr("cx", function(d) {
                return x(d.vitalTime);
            }).attr("cy", function(d) {
                return y(d.unitValue1);
            }).on("click", function(i) {
                //d3.event.stopPropagation();

                // When a value is clicked, show the tooltip and load the table
                div.transition()
                    .duration(200)
                    .style("opacity", 1.0);
                div.style("left", (width / 2 - 150) + "px")
                    .style("top", (height / 2 - 28) + "px")
                    .style("pointer-events", "auto");
console.log('vital time : '+i.vitalTime)
                tabulate(div, dataNest[segment].values, ["space", "id", "vitalTime", "space", "unitValue1", "space", "additionalInformation", "space"], i.vitalTime, checkLeftDate(i.vitalTime), checkRightDate(i.vitalTime));
            });

        chartBody.selectAll(".line").data(data)
    }
}

// Reloads the graph based on the zoom selection
function zoom(event) {
    if (patVitalInfos != null) {
        var val = $("#zoomSelect").val();
        if (val == "7 day") {
            zoomDays = 7;
            reloadGraph();
        } else if (val == "30 day") {
            zoomDays = 30;
            reloadGraph();
        } else if (val == "90 day") {
            zoomDays = 90;
            reloadGraph();
        }
    }
}

// Clears then loads the graph
function reloadGraph() {
    clearGraph();
    loadGraph();
}

// Does the inital load, sets the graph size and calls for the data
$(document).ready(function() {
    getMealSchedule();
    $(".zoomButton").click(zoom);
    var id = $("#contextPatientId").val();

    if (id == "" || isNaN(id)) {
        id = $("#currentUserId").val();
    }

    /* Find the new window dimensions */
    width = parseInt($(".graph-content").width() - margin.right - margin.left);
    height = parseInt(500 - 42 - margin.top - margin.bottom);

    // Set the ranges
    x = d3.time.scale().range([0, width]);
    y = d3.scale.linear().range([height, 0]);
    //id = 57;
    if (id != 0) {
        zoomDays = 7;
        getVitalsGraphData(id);
    }
});

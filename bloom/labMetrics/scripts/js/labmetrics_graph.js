var patVitalInfos;
var dataNest;
var parseDate = d3.time.format("%Y-%m-%dT%H:%M:%S.%L%Z").parse;

function getPatientLabMetricsByPatientId(id) {
    var arr = new Array();
    arr[0] = id;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'getPatientLabMetricsByPatientId', processResponse);
}

function loadGraph(series) {
    series.sort(function(a, b) {
        if (a.labResultDate < b.labResultDate) {
            return -1;
        }
        if (a.labResultDate > b.labResultDate) {
            return 1;
        }
        return 0;
    });

    d3.select("#graph-content")
        .datum(series)
        .call(biometricsChart()
            .x(function(d) {
                return parseDate(d.labResultDate);
            })
            .y(function(d) {
                return parseFloat(d.unitvalue1);
            })
            .lineName(function(d) {
                return d.LabMetricDescription;
            })
            .yLabel(series[0].unit)
            .height(500)
            .nest(function(d) {
                return d.LabMetricDescription;
            })
            .xDomain(function() {
                var endDate = new Date();
                var startDate = new Date();
                startDate.setDate(startDate.getDate() - 365);
                return [startDate, endDate];
            })
            .width($("#menu-content").width()));

    d3.select("#table-content")
        .datum(series)
        .call(table()
            .headers(function(d) {
                return parseDate(d.labResultDate);
            })
            .row1(function(d) {
                return parseFloat(d.unitvalue1);
            })
            .rowName1(function(d) {
                return d.LabMetricDescription;
            }));
}

function loadMultiGraph(series) {
    series.forEach(function(d) {
        d.values.sort(function(a, b) {
            if (a.labResultDate < b.labResultDate) {
                return -1;
            }
            if (a.labResultDate > b.labResultDate) {
                return 1;
            }
            return 0;
        });
    });

    d3.select("#graph-content")
        .datum(series)
        .call(biometricsMultiChart()
            .x(function(d) {
                return parseDate(d.labResultDate);
            })
            .y(function(d) {
                return parseFloat(d.unitvalue1);
            })
            .lineName(function(d) {
                return d.LabMetricDescription;
            })
            .yLabel(series[0].values[0].unit)
            .height(500)
            .nest(function(d) {
                return d.LabMetricDescription;
            })
            .xDomain(function() {
                var endDate = new Date();
                var startDate = new Date();
                startDate.setDate(startDate.getDate() - 365);
                return [startDate, endDate];
            })
            .width($("#menu-content").width()));

    d3.select("#table-content")
        .datum(series)
        .call(multiTable()
            .headers(function(d) {
                return parseDate(d.labResultDate);
            })
            .row1(function(d) {
                return parseFloat(d.unitvalue1);
            })
            .rowName1(function(d) {
                return d.LabMetricDescription;
            }));
}

function processResponse(result) {
    patVitalInfos = JSON.parse(result.message);

    if (patVitalInfos.length > 0) {
        d3.select("h1").style("visibility", "hidden");
        d3.select("#segment-select").style("visibility", "visible");

        var endDate = new Date();
        var startDate = new Date();
        startDate.setDate(startDate.getDate() - 365);

        var newVitalInfos = [];

        patVitalInfos.forEach(function(element, index, array) {
            if (!(parseDate(element.labResultDate) < startDate) && !(parseDate(element.labResultDate) > endDate)) {
                newVitalInfos.push(element);
            }
        });

        patVitalInfos = newVitalInfos;

        dataNest = d3.nest().key(function(d) {
            return d.LabMetricDescription;
        }).entries(patVitalInfos);

        if (dataNest.length > 0) {

            var series = dataNest[0].values;

            var segment = d3.select("#segment-select");

            var addCholesterolHDL = false;

            for (i = 0; i < dataNest.length; ++i) {
                if (dataNest[i].key != "HDL (High Density Lipoprotein)" && dataNest[i].key != "Total Cholesterol") {
                    segment.append("option").html(dataNest[i].key);
                } else {
                    addCholesterolHDL = true;
                }
            }

            if (addCholesterolHDL) {
                segment.append("option").html("Total Cholesterol/HDL");
            }

            setTitle(dataNest[0].key);
            loadGraph(dataNest[0].values);
        }
    }
}

function clearGraph() {
    $("#graph-content").empty();
    $("#table-content").empty();
}

$(document).ready(function() {
    var id = $("#contextPatientId").val();

    if (id == "" || isNaN(id)) {
        id = $("#currentUserId").val();
    }

    if (id != 0) {
        getPatientLabMetricsByPatientId(id);
    }

    $(".menu-item").click(changeGraph);

    if ($('#contextPatientName').val() != "") {
        $('#selectedPatient').find('img').attr('src', $('#contextPatientImage').val());
        $('#selectedPatient').find('span').html($('#contextPatientName').val());
    } else {
        $('#selectedPatient').hide();
    }
});

function reloadGraph(series) {
    clearGraph();

    if (series.length > 0 && series[0].key == null) {
        loadGraph(series);
    } else if (series.length > 0) {
        loadMultiGraph(series);
    }
}

function setTitle(title) {
    $("h3").html(title);
}

function changeGraph(event) {
    var series;
    var selectedValue = $("select option:selected").val();

    if (selectedValue != "Total Cholesterol/HDL") {

        for (i = 0; i < dataNest.length; ++i) {
            if (dataNest[i].key == selectedValue) {
                series = dataNest[i].values;
                setTitle(dataNest[i].key);
                reloadGraph(series);
                break;
            }
        }
    } else {
        setTitle(selectedValue);
        series = [];

        for (i = 0; i < dataNest.length; ++i) {
            if (dataNest[i].key == "Total Cholesterol") {
                series.push(dataNest[i]);
                break;
            }
        }

        for (i = 0; i < dataNest.length; ++i) {
            if (dataNest[i].key == "HDL (High Density Lipoprotein)") {
                series.push(dataNest[i]);
                break;
            }
        }

        reloadGraph(series);
    }
}

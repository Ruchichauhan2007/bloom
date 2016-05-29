function biometricsChart() {
    var margin = {
            top: 60,
            right: 20,
            bottom: 40,
            left: 40
        },
        width = 1024,
        height = 768,
        yLabel = "",
        xValue = function(d) {
            return d[1];
        },
        yValue = function(d) {
            return d[2];
        },
        lineNameValue = function(d) {
            return d[0];
        },
        nestValue = function(d) {
            return d[3];
        },
        xDomainValue = function() {
            return [0, 1];
        },
        xScale = d3.time.scale(),
        yScale = d3.scale.linear(),
        xAxis = d3.svg.axis().scale(xScale).orient("bottom").ticks(12).tickPadding(12).tickFormat(d3.time.format("%b")),
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(10).tickPadding(12),
        area = d3.svg.area().x(X).y1(Y),
        line = d3.svg.area().x(X).y(Y);

    function chart(selection) {
        var color = d3.scale.ordinal().range(["#1f77b4", "#31a354"]);
        selection.each(function(data) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = data.map(function(d, i) {
                return [lineNameValue.call(data, d, i), xValue.call(data, d, i), yValue.call(data, d, i), nestValue.call(data, d, i)];
            });
            if (data.length > 0) {
                // Update the x-scale.
                xScale
                    .domain(xDomainValue())
                    .range([0, width - margin.left - margin.right]);

                // Update the y-scale.
                yScale
                    .domain([0, d3.max(data, function(d) {
                        return d[2];
                    }) * 1.1])
                    .range([height - margin.top - margin.bottom, 0]);

                // Select the svg element, if it exists.
                var svg = d3.select(this).selectAll("svg").data([data]);

                // Otherwise, create the skeletal chart.
                svg.enter().append("svg").append("defs").append("svg:clipPath")
                    .attr("id", "clip")
                    .append("svg:rect")
                    .attr("id", "clip-rect")
                    .attr("x", "0")
                    .attr("y", "-5")
                    .attr("width", width + 5)
                    .attr("height", height + 5);
                var gEnter = svg.append("g").attr("clip-path", "url(#clip)")
                    .attr("width", width - margin.left - margin.right)
                    .attr("height", height - margin.top - margin.bottom);

                gEnter.append("path").attr("class", "line").attr("data-legend", function(d) {
                    return d[0][0];
                }).style("stroke", color(data[0][0]));
                gEnter.append("g").attr("class", "x axis");
                svg.append("g").attr("class", "y axis");

                // Update the outer dimensions.
                svg.attr("width", width)
                    .attr("height", height);

                // Update the inner dimensions.
                var g = svg.select("g")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

                // Update the line path.
                g.select(".line")
                    .attr("d", line);


                g.selectAll("dot").data(data).enter().append("circle").attr("r", 5).attr("fill", function(d) {
                    return color(data[0][0]);
                }).attr("cx", function(d) {
                    return xScale(d[1]);
                }).attr("cy", function(d) {
                    return yScale(d[2]);
                });

                // Update the x-axis.
                g.select(".x.axis")
                    .attr("transform", "translate(0," + yScale.range()[0] + ")")
                    .call(xAxis.tickSize(-yScale.range()[0], -yScale.range()[0]));

                svg.select(".y.axis")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
                    .call(yAxis.tickSize(-xScale.range()[1], -xScale.range()[1]));

                if (yLabel != "") {
                    if (yLabel == "%") {
                        yLabel = "percent";
                    }
                    svg.append("text")
                        .attr("class", "y label")
                        .attr("text-anchor", "end")
                        .attr("y", 30)
                        .attr("x", 50)
                        .attr("dy", ".75em")
                        .text(yLabel);
                }
            }
        });
    }

    // The x-accessor for the path generator; xScale ∘ xValue.
    function X(d) {
        return xScale(d[1]);
    }

    // The x-accessor for the path generator; yScale ∘ yValue.
    function Y(d) {
        return yScale(d[2]);
    }

    chart.margin = function(_) {
        if (!arguments.length) return margin;
        margin = _;
        return chart;
    };

    chart.lineName = function(_) {
        if (!arguments.length) return lineNameValue;
        lineNameValue = _;
        return chart;
    }

    chart.width = function(_) {
        if (!arguments.length) return width;
        width = _;
        return chart;
    };

    chart.height = function(_) {
        if (!arguments.length) return height;
        height = _;
        return chart;
    };

    chart.x = function(_) {
        if (!arguments.length) return xValue;
        xValue = _;
        return chart;
    };

    chart.y = function(_) {
        if (!arguments.length) return yValue;
        yValue = _;
        return chart;
    };

    chart.yLabel = function(_) {
        if (!arguments.length) return yLabel;
        yLabel = _;
        return chart;
    }

    chart.nest = function(_) {
        if (!arguments.length) return nestValue;
        nestValue = _;
        return chart;
    }

    chart.xDomain = function(_) {
        if (!arguments.length) return xDomainValue;
        xDomainValue = _;
        return chart;
    }

    return chart;
}

function biometricsMultiChart() {
    var margin = {
            top: 60,
            right: 20,
            bottom: 40,
            left: 40
        },
        width = 1024,
        height = 768,
        yLabel = "",
        xValue = function(d) {
            return d[1];
        },
        yValue = function(d) {
            return d[2];
        },
        lineNameValue = function(d) {
            return d[0];
        },
        nestValue = function(d) {
            return d[3];
        },
        xDomainValue = function() {
            return [0, 1];
        },
        dataValues = function(d) {
            return d.values;
        },
        xScale = d3.time.scale(),
        yScale = d3.scale.linear(),
        xAxis = d3.svg.axis().scale(xScale).orient("bottom").ticks(12).tickPadding(12).tickFormat(d3.time.format("%b")),
        yAxis = d3.svg.axis().scale(yScale).orient("left").ticks(10).tickPadding(12),
        area = d3.svg.area().x(X).y1(Y);

    function chart(selection) {
        var color = d3.scale.ordinal().range(["#1f77b4", "#31a354"]);
        selection.each(function(data) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.

            var colorDomain = [];

            data.forEach(function(element, index, array) {
                data[index] = dataValues(element).map(function(d, i) {
                    return [lineNameValue.call(dataValues(element), d, i), xValue.call(dataValues(element), d, i), yValue.call(dataValues(element), d, i), nestValue.call(dataValues(element), d, i)];
                });

                colorDomain.push(data[index][0][0]);
            });

            color.domain(colorDomain);

            if (data.length > 0) {

                // Update the x-scale.
                xScale
                    .domain(xDomainValue())
                    .range([0, width - margin.left - margin.right]);

                var max = 0;

                data.forEach(function(element, index, array) {
                    var seriesMax = d3.max(element, function(d) {
                        return d[2];
                    });

                    if (seriesMax > max) {
                        max = seriesMax;
                    }
                });

                // Update the y-scale.
                yScale
                    .domain([0, max * 1.1])
                    .range([height - margin.top - margin.bottom, 0]);

                // Select the svg element, if it exists.
                var svg = d3.select(this).selectAll("svg").data([data]);

                // Otherwise, create the skeletal chart.
                svg.enter().append("svg").append("defs").append("svg:clipPath")
                    .attr("id", "clip")
                    .append("svg:rect")
                    .attr("id", "clip-rect")
                    .attr("x", "0")
                    .attr("y", "-5")
                    .attr("width", width + 5)
                    .attr("height", height + 5);
                var gEnter = svg.append("g").attr("clip-path", "url(#clip)")
                    .attr("width", width - margin.left - margin.right)
                    .attr("height", height - margin.top - margin.bottom);

                data.forEach(function(element, index, array) {
                    gEnter.append("path").attr("class", "line" + index).attr("id", element[0][0]).style("stroke", color(element[0][0]));
                });

                gEnter.append("g").attr("class", "x axis");
                svg.append("g").attr("class", "y axis");

                // Update the outer dimensions.
                svg.attr("width", width)
                    .attr("height", height);

                // Update the inner dimensions.
                var g = svg.select("g")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

                g.append("defs").append("svg:clipPath")
                    .attr("id", "clip")
                    .append("svg:rect")
                    .attr("id", "clip-rect")
                    .attr('fill', '#D8D8D8')
                    .attr("x", "0")
                    .attr("y", "0")
                    .attr("width", margin.left)
                    .attr("height", height);

                data.forEach(function(element, index, array) {
                    var newData = [element];
                    line = d3.svg.line().x(function(d) {
                        return xScale(d[1]);
                    }).y(function(d) {
                        return yScale(d[2]);
                    });

                    g.select(".line" + index).data(newData).attr("d", line);
                    //.attr("d", path.attr("d") + "Z");
                });
                // Update the line path.


                data.forEach(function(element, index, array) {
                    g.selectAll("dot").data(element).enter().append("circle").attr("r", 5).attr("fill", function(d) {
                        return color(element[0][0]);
                    }).attr("cx", function(d) {
                        return xScale(d[1]);
                    }).attr("cy", function(d) {
                        return yScale(d[2]);
                    });
                });
                // Update the x-axis.
                g.select(".x.axis")
                    .attr("transform", "translate(0," + yScale.range()[0] + ")")
                    .call(xAxis.tickSize(-yScale.range()[0], -yScale.range()[0]));

                svg.select(".y.axis")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
                    .call(yAxis.tickSize(-xScale.range()[1], -xScale.range()[1]));

                if (yLabel != "") {
                    svg.append("text")
                        .attr("class", "y label")
                        .attr("text-anchor", "end")
                        .attr("y", 30)
                        .attr("x", 50)
                        .attr("dy", ".75em")
                        .text(yLabel);
                }

                if (data.length > 0 && data[0][0] != "") {

                    var division = 0.125;

                    data.forEach(function(element, index, array) {

                        svg.append("text")
                            .attr("class", "line-title")
                            .attr("text-anchor", "start")
                            .attr("y", 15)
                            .attr("x", width * division)
                            .attr("dy", ".75em")
                            .text(element[0][0]);

                        svg.append("rect").attr("width", 10).attr("height", 10).attr("fill", function(d) {
                                return color(element[0][0]);
                            }).attr("x", width * division - 15)
                            .attr("y", 16);

                        division = division * 5;
                    });
                }
            }
        });
    }

    // The x-accessor for the path generator; xScale ∘ xValue.
    function X(d) {
        return xScale(d[1]);
    }

    // The x-accessor for the path generator; yScale ∘ yValue.
    function Y(d) {
        return yScale(d[2]);
    }

    chart.margin = function(_) {
        if (!arguments.length) return margin;
        margin = _;
        return chart;
    };

    chart.lineName = function(_) {
        if (!arguments.length) return lineNameValue;
        lineNameValue = _;
        return chart;
    }

    chart.width = function(_) {
        if (!arguments.length) return width;
        width = _;
        return chart;
    };

    chart.height = function(_) {
        if (!arguments.length) return height;
        height = _;
        return chart;
    };

    chart.x = function(_) {
        if (!arguments.length) return xValue;
        xValue = _;
        return chart;
    };

    chart.y = function(_) {
        if (!arguments.length) return yValue;
        yValue = _;
        return chart;
    };

    chart.yLabel = function(_) {
        if (!arguments.length) return yLabel;
        yLabel = _;
        return chart;
    }

    chart.nest = function(_) {
        if (!arguments.length) return nestValue;
        nestValue = _;
        return chart;
    }

    chart.xDomain = function(_) {
        if (!arguments.length) return xDomainValue;
        xDomainValue = _;
        return chart;
    }

    chart.values = function(_) {
        if (!arguments.length) return dataValues;
        dataValues = _;
        return chart;
    }

    return chart;
}

function table() {
    var formatDate = d3.time.format("%m/%d/%y");

    var headerValue = function(d) {
            return d[0];
        },
        rowValue1 = function(d) {
            return d[1];
        },
        rowValue2 = function(d) {
            return null;
        },
        rowName1 = function(d) {
            return "";
        },
        rowName2 = function(d) {
            return "";
        };;

    function tabulate(selection) {

        selection.each(function(data) {
            // Convert data to standard representation greedily;
            // this is needed for nondeterministic accessors.
            data = data.map(function(d, i) {
                return [headerValue.call(data, d, i), rowName1.call(data, d, i), rowName2.call(data, d, i), rowValue1.call(data, d, i), rowValue2.call(data, d, i)];
            });

            if (data.length > 0) {

                var table = d3.select(this).selectAll("table").data([data]);
                table.enter().append("table");

                var headerRow = table.append("tr");

                headerRow.selectAll("th")
                    .data(data)
                    .enter()
                    .append("th")
                    .text(function(d) {
                        return formatDate(d[0]);
                    });

                headerRow.insert("th", ":first-child").text("Date");

                for (i = 3; i < data[0].length; ++i) {
                    if (data[0][i] != null) {
                        var tableRow = table.append("tr");
                        tableRow.selectAll("td")
                            .data(data)
                            .enter()
                            .append("td")
                            .text(function(d) {
                                return d[i];
                            });

                        tableRow.insert("th", ":first-child").text(data[0][1]);
                    }
                }
            }
        });
    }

    tabulate.headers = function(_) {
        if (!arguments.length) return headerValue;
        headerValue = _;
        return tabulate;
    };

    tabulate.row1 = function(_) {
        if (!arguments.length) return rowValue1;
        rowValue1 = _;
        return tabulate;
    };

    tabulate.row2 = function(_) {
        if (!arguments.length) return rowValue2;
        rowValue2 = _;
        return tabulate;
    }

    tabulate.rowName1 = function(_) {
        if (!arguments.length) return rowName1;
        rowName1 = _;
        return tabulate;
    }

    tabulate.rowName2 = function(_) {
        if (!arguments.length) return rowName2;
        rowName2 = _;
        return tabulate;
    }

    return tabulate;
}

function multiTable() {
    var formatDate = d3.time.format("%m/%d/%y");

    var headerValue = function(d) {
            return d[0];
        },
        rowValue1 = function(d) {
            return d[1];
        },
        rowValue2 = function(d) {
            return null;
        },
        rowName1 = function(d) {
            return "";
        },
        rowName2 = function(d) {
            return "";
        },
        dataValues = function(d) {
            return d.values;
        };

    function tabulate(selection) {

        selection.each(function(data) {

            if (data.length > 0) {

                var table = d3.select(this).selectAll("table").data([data]);
                table.enter().append("table");

                var headerRow = table.append("tr");

                var headerItems = [];
                var duplicateHeaderItems = [];

                data.forEach(function(element, index, array) {
                    element.forEach(function(item, i, arr) {
                        duplicateHeaderItems.push(formatDate(item[1]));
                    });
                });

                $.each(duplicateHeaderItems, function(i, el) {
                    if ($.inArray(el, headerItems) === -1) headerItems.push(el);
                });

                headerItems.sort(function(a, b) {
                    if (new Date(a) < new Date(b)) {
                        return -1;
                    }
                    if (new Date(a) > new Date(b)) {
                        return 1;
                    }
                    return 0;
                });

                headerRow.selectAll("th")
                    .data(headerItems)
                    .enter()
                    .append("th")
                    .text(function(d) {
                        return d;
                    });

                headerRow.insert("th", ":first-child").text("Date");

                data.forEach(function(element, index, array) {
                    if (element.length > 0 && element[0][0] != null) {
                        var tableRow = table.append("tr");
                        tableRow
                            .append("th")
                            .text(element[0][0]);

                        var times_through = 0;

                        headerItems.forEach(function(item, i, arry) {
                            var item_to_append = null;
                            element.forEach(function(thing, index, arr) {
                                if (formatDate(thing[1]) == item) {
                                    item_to_append = thing[2];
                                }
                            });

                            tableRow
                                .append("td")
                                .text(function(d) {
                                    if (item_to_append == null) {
                                        return " ";
                                    } else {
                                        return item_to_append;
                                    }
                                });

                            times_through++;
                        });
                    }
                });
            }
        });
    }

    tabulate.headers = function(_) {
        if (!arguments.length) return headerValue;
        headerValue = _;
        return tabulate;
    };

    tabulate.row1 = function(_) {
        if (!arguments.length) return rowValue1;
        rowValue1 = _;
        return tabulate;
    };

    tabulate.row2 = function(_) {
        if (!arguments.length) return rowValue2;
        rowValue2 = _;
        return tabulate;
    }

    tabulate.rowName1 = function(_) {
        if (!arguments.length) return rowName1;
        rowName1 = _;
        return tabulate;
    }

    tabulate.rowName2 = function(_) {
        if (!arguments.length) return rowName2;
        rowName2 = _;
        return tabulate;
    }

    tabulate.values = function(_) {
        if (!arguments.length) return dataValues;
        dataValues = _;
        return tabulate;
    }

    return tabulate;
}

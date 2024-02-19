        // Sample data for the chart
        var data1 = {
            labels: ['ج', 'خ', 'ارب', 'ث',"اث", "ح", "س"],
            datasets: [{
                label: 'Custom Chart',
                data: [2 ,5, 4, 2, 6, 3, 4],
                backgroundColor: [
                        'rgba(115, 103, 240, 0.16)',
                        'rgba(115, 103, 240, 0.16)',
                        'rgba(115, 103, 240, 0.16)',
                        'rgba(115, 103, 240, 0.16)',
                        '#7367F0',
                        'rgba(115, 103, 240, 0.16)',
                        'rgba(115, 103, 240, 0.16)'
            ], // Set the background color with alpha for transparency
            borderRadius: {
                topLeft: 5,
                topRight: 5,
                bottomRight: 5,
                bottomLeft: 5
            },
                borderSkipped: false,// Set the border radius for bars
                borderWidth: 0, // Remove the border
                barThickness: 25
        }]
    };
        // Chart configuration
        var options = {
            scales: {
                x: {
                border: {
                    display: false
                },
                grid: {
                    drawOnChartArea: false,
                    drawTicks: false
                },
                display: true, // Hide the x-axis
            },
                y: {
                  display: false, // Hide the y-axis
            }
        },
            plugins: {
                legend: {
                display: false
            },
                tooltip: {
                enabled: false
            }
        }
    };

        // Create the chart
        var ctx = document.getElementById('customChart').getContext('2d');
        var myChart1 = new Chart(ctx, {
            type: 'bar',
            data: data1,
            options: options
        });
        // Add custom text above each bar
        var barController = myChart1.getDatasetMeta(0).data;
        barController.forEach(function(bar, index) {
            var text = 'Value: ' + data1.datasets[0].data[index];
            ctx.textAlign = 'center';
            ctx.fillStyle = '#ccc';
          ctx.fillText(text, bar.x, bar.y - 10); // Adjust the y-coordinate for text placement
        });    





        // setup 
        const data11x = {
            labels: ['نوف', 'اوك', 'سبتمبر', 'اغسط', 'حول', 'بوني', 'ماي', "ابر", "مار" , "فب", "بن"],
                datasets: [{
                label: 'مصروف',
                data: [5, 10, 10, 5, 12, 10, 4, 6 ,7 ,8, 6],
                backgroundColor: "#FF9F43",
                borderWidth: 10,
                borderColor: "white",
                barThickness: 30,
                borderRadius: {
                    topLeft: 50,
                    topRight: 50,
                    bottomRight: 50,
                    bottomLeft: 50
                },
                borderSkipped: false
                },
            {
                label: 'كسب',
                data: [10, 10, 6, 10, 8, 3, 9, 6, 10, 6, 10],
                backgroundColor: "#7367F0",
                borderWidth: 10,
                borderColor: "white",
                barThickness: 30,
                borderRadius: {
                    topLeft: 50,
                    topRight: 50,
                    bottomLeft: 50,
                    bottomRight: 50
                },
                borderSkipped: false
            }]
        };

        // config 
        const config11x = {
            type: 'bar',
            data: data11x,
            options: {
                plugins: {
                    legend: {
                        align: 'start',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
            scales: {
                x: {
                stacked: true,
                border: {
                    display: false
                },
                grid: {
                    drawOnChartArea: false,
                    drawTicks: false
                },
            },
                y: {
                beginAtZero: true,
                stacked : true,
                border: {
                        display: false
                    },
                grid: {
                        drawOnChartArea: false,
                        drawTicks: false
                },
            }
            }
        }
    };

        // render init block
        const myChart11x = new Chart(
            document.getElementById('myChart2x'),
            config11x
        );

        // Instantly assign Chart.js version
        const chartVersion10 = document.getElementById('chartVersion');
        // chartVersion.innerText = Chart.version;






    const data = {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [{
        label: 'Weekly Sales',
        data: [7, 4, 6, 4, 6, 5],
        borderColor: "#7367F0",
        borderSkipped: false,// Set the border radius for bars
        tension: 0.4,
        pointRadius: 0
      },{
        label: 'Weekly Sales',
        data: [5, 2, 4, 2, 4, 3],
        borderColor: "#DBDADE",
        borderSkipped: false,// Set the border radius for bars
        tension: 0.4,
        pointRadius: 0,
        segment: {
          borderDash: [10]
        }
      }]
      
    };
  
    // config 
    const config = {
      type: 'line',
      data,
      options: {
        plugins: {
            legend: {
              display: false
            }
        },
        scales: {
          y: {
            display: false,
            beginAtZero: true
          },
          x: {
            border: {
                    display: false
                },
                grid: {
                    drawOnChartArea: false,
                    drawTicks: false
                },
                display: false, // Hide the x-axis
          },
          
        }
      }
    };
  
    // render init block
    const myChart5 = new Chart(
      document.getElementById('myChart5'),
      config
    );
  
    // Instantly assign Chart.js version
    const chartVersion = document.getElementById('chartVersion');
    // chartVersion.innerText = Chart.version;








    //     // Sample data for the chart
        var data3 = {
            labels: ['Jan', 'Feb', 'Mar', 'Abr',"May", "Jun", "Jul", "Aug", "Sep"],
            datasets: [{
            label: 'Custom Chart',
            data: [1 , .8, 2.5, 2.1, 1.7, 1.8, 2, 1, .5],
            backgroundColor: [
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    '#7367F0',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)'
            ], // Set the background color with alpha for transparency
            borderRadius: {
                topLeft: 5,
                topRight: 5,
                bottomRight: 5,
                bottomLeft: 5
            },
            borderSkipped: false, // Set the border radius for bars
            borderWidth: 0, // Remove the border
            barThickness: 25,
        }]
    };
        // Chart configuration
        var options = {
            scales: {
            x: {
                staked: true,
                grid: {
                    drawOnChartArea: false,
                    drawTicks: false
                },
                display: true, // Hide the x-axis
            },
            y: {
                border: {
                    display: false 
                },
                grid: {
                    drawOnChartArea: false,
                    drawTicks: false
                },
                staked: true,
                // display: false // Hide the y-axis
            }
        },
        // plugins: [ChartDataLabels],
        plugins: {
            legend: {
                display: false
            },
                tooltip: {
                enabled: false
            }
        },
    };
        // Create the chart
        var ctx = document.getElementById('customChart3').getContext('2d');
        var myChart3 = new Chart(ctx, {
            type: 'bar',
            data: data3,
            options: options
        });
        // Add custom text above each bar
        var barController = myChart3.getDatasetMeta(0).data;
        barController.forEach(function(bar, index) {
            var text = 'Value: ' + data3.datasets[0].data[index];
            ctx.textAlign = 'center';
            ctx.fillStyle = 'black';
            ctx.fillText(text, bar.x, bar.y - 15); // Adjust the y-coordinate for text placement
        });




        var data4 = {
            labels: ['Jan', 'Feb', 'Mar', 'Abr',"May", "Jun", "Jul", "Aug", "Sep"],
            datasets: [{
            label: 'Custom Chart',
            data: [1 , .8, 2.5, 2.1, 1.7, 1.8, 2, 1, .5],
            backgroundColor: [
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    '#7367F0',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)'
            ], // Set the background color with alpha for transparency
            borderRadius: {
                topLeft: 5,
                topRight: 5,
                bottomRight: 5,
                bottomLeft: 5
            },
            borderSkipped: false, // Set the border radius for bars
            borderWidth: 0, // Remove the border
            barThickness: 25,
        }]
    };
        // Chart configuration
        var options = {
            scales: {
            x: {
                staked: true,
                grid: {
                    drawOnChartArea: false,
                    drawTicks: false
                },
                display: true, // Hide the x-axis
            },
            y: {
                border: {
                    display: false 
                },
                grid: {
                    drawOnChartArea: false,
                    drawTicks: false
                },
                staked: true,
                // display: false // Hide the y-axis
            }
        },
        // plugins: [ChartDataLabels],
        plugins: {
            legend: {
                display: false
            },
                tooltip: {
                enabled: false
            }
        },
    };
        // Create the chart
        var ctx = document.getElementById('customChart4').getContext('2d');
        var myChart3 = new Chart(ctx, {
            type: 'bar',
            data: data4,
            options: options
        });
        // Add custom text above each bar
        var barController = myChart3.getDatasetMeta(0).data;
        barController.forEach(function(bar, index) {
            var text = 'Value: ' + data3.datasets[0].data[index];
            ctx.textAlign = 'center';
            ctx.fillStyle = 'black';
            ctx.fillText(text, bar.x, bar.y - 15); // Adjust the y-coordinate for text placement
        });






        var data5 = {
            labels: ['Jan', 'Feb', 'Mar', 'Abr',"May", "Jun", "Jul", "Aug", "Sep"],
            datasets: [{
            label: 'Custom Chart',
            data: [1 , .8, 2.5, 2.1, 1.7, 1.8, 2, 1, .5],
            backgroundColor: [
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    '#7367F0',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)',
                    'rgba(115, 103, 240, 0.16)'
            ], // Set the background color with alpha for transparency
            borderRadius: {
                topLeft: 5,
                topRight: 5,
                bottomRight: 5,
                bottomLeft: 5
            },
            borderSkipped: false, // Set the border radius for bars
            borderWidth: 0, // Remove the border
            barThickness: 25,
        }]
    };
        // Chart configuration
        var options = {
            scales: {
            x: {
                staked: true,
                grid: {
                    drawOnChartArea: false,
                    drawTicks: false
                },
                display: true, // Hide the x-axis
            },
            y: {
                border: {
                    display: false 
                },
                grid: {
                    drawOnChartArea: false,
                    drawTicks: false
                },
                staked: true,
                // display: false // Hide the y-axis
            }
        },
        // plugins: [ChartDataLabels],
        plugins: {
            legend: {
                display: false
            },
                tooltip: {
                enabled: false
            }
        },
    };
        // Create the chart
        var ctx = document.getElementById('customChart5').getContext('2d');
        var myChart3 = new Chart(ctx, {
            type: 'bar',
            data: data5,
            options: options
        });
        // Add custom text above each bar
        var barController = myChart3.getDatasetMeta(0).data;
        barController.forEach(function(bar, index) {
            var text = 'Value: ' + data3.datasets[0].data[index];
            ctx.textAlign = 'center';
            ctx.fillStyle = 'black';
            ctx.fillText(text, bar.x, bar.y - 15); // Adjust the y-coordinate for text placement
        });



// handle taps
        let buttoms = document.querySelectorAll(".buttoms button");
        buttoms.forEach(button => {
            button.addEventListener("click", () => {

                buttoms.forEach(btn => {
                    btn.classList.remove("active");
                })

                button.classList.add("active");

                document.querySelectorAll(".canvas").forEach(canvas => {

                    canvas.classList.add("none");

                })

                if (button.dataset.chart == "customChart3") {

                    document.getElementById("customChart3").classList.remove("none");
                    
                } else if (button.dataset.chart == "customChart4") {

                    document.getElementById("customChart4").classList.remove("none");

                } else if (button.dataset.chart == "customChart5") {

                    document.getElementById("customChart5").classList.remove("none");

                }

            })
        })
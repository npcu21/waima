<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Waima Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="styles/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    body {
      background-color: #f8f9fa;
    }
   
    .chart-container {
      width: 100%;
      position: relative;
      height: auto;
    }
    
    .chart-container canvas {
      width: 100% !important;
      max-width: 100%;
      height: auto !important;
    }
    h4 {
        color: #116bac;
    }
    .card-stats {
        border-left: 5px solid #116bac;
    }
    
    .card-body {
      padding: 20px;
    }
  </style>
 
</head>
<body>

  <!-- Top Navbar -->
@include('includes.navbar')


<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="container mt-5">
              <h3 class="mb-4 text-center">Category Data Chart</h3>
            
              <!-- Bar Chart -->
              <div class="chart-container mb-4">
                <canvas id="categoryChart"></canvas>
              </div>
            
              <!-- Category Summary Cards -->
              <div class="row mb-4 gy-3">
                <div class="col-md-4">
                  <div class="card shadow-sm card-stats success">
                    <div class="card-body">
                      <h6 class="card-title">Seeds</h6>
                      <h4 class="font-46 mb-0">{{ $counts['seeds'] ?? 0 }}</h4>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow-sm card-stats">
                    <div class="card-body">
                      <h6 class="card-title">Mineral fertilizers</h6>
                      <h4 class="font-46 mb-0">{{ $counts['mineral_fertilizers'] ?? 0 }}</h4>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow-sm card-stats">
                    <div class="card-body">
                      <h6 class="card-title">Organic Amendment</h6>
                      <h4 class="font-46 mb-0">{{ $counts['organic_amendments'] ?? 0 }}</h4>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow-sm card-stats">
                    <div class="card-body">
                      <h6 class="card-title">Biostimulants</h6>
                      <h4 class="font-46 mb-0">{{ $counts['bio_stimulants'] ?? 0 }}</h4>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow-sm card-stats">
                    <div class="card-body">
                      <h6 class="card-title">Inorganic Soil Conditioners</h6>
                      <h4 class="font-46 mb-0">{{ $counts['inorganic_soil_conditioners'] ?? 0 }}</h4>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow-sm card-stats">
                    <div class="card-body">
                      <h6 class="card-title">Synthetic Pesticides</h6>
                      <h4 class="font-46 mb-0">{{ $counts['synthetic_pesticides'] ?? 0 }}</h4>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow-sm card-stats secondary">
                    <div class="card-body">
                      <h6 class="card-title">Animal Feed</h6>
                      <h4 class="font-46 mb-0">{{ $counts['animal_feeds'] ?? 0 }}</h4>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow-sm card-stats">
                    <div class="card-body">
                      <h6 class="card-title">Veterinary Products</h6>
                      <h4 class="font-46 mb-0">{{ $counts['veterinary_products'] ?? 0 }}</h4>
                    </div>
                  </div>
                </div>
              </div>
            
            </div>

        </div>
    </div>
</div>
  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Function to wrap long labels
  function wrapLabel(label, maxWidth = 12) {
      const words = label.split(" ");
      const lines = [];
      let current = "";

      words.forEach(word => {
          if ((current + word).length <= maxWidth) {
              current += word + " ";
          } else {
              lines.push(current.trim());
              current = word + " ";
          }
      });

      lines.push(current.trim());
      return lines; // Chart.js will show each array item on new line
  }

  // Dynamic labels from Laravel + wrap
  const categoryLabels = @json(array_keys($counts))
      .map(l => l.replace(/_/g, " ").toUpperCase())
      .map(label => wrapLabel(label, 12)); // <-- WRAPPING WORKS HERE

  const categoryDataValues = @json(array_values($counts));

  const colors = ['#28a745', '#007bff', '#6c757d', '#17a2b8', '#03a358', '#dc3545', '#fd7e14', '#6f42c1'];

  const categoryData = {
      labels: categoryLabels,
      datasets: [{
          label: 'Products Count',
          data: categoryDataValues,
          backgroundColor: colors,
          borderColor: colors,
          borderWidth: 1
      }]
  };

  const categoryOptions = {
      responsive: true,
      plugins: {
          legend: { position: 'top' },
          tooltip: {
              callbacks: {
                  label: function(tooltipItem) {
                      return `${tooltipItem.label}: ${tooltipItem.raw} products`;
                  }
              }
          },
          title: {
              display: true,
              text: 'Products Count Overview'
          }
      },
      scales: {
          x: {
              ticks: {
                  font: { size: 14 },
                  maxRotation: 0,
                  minRotation: 0,
              }
          },
          y: {
              beginAtZero: true
          }
      }
  };

  // Create Chart
  const ctx = document.getElementById('categoryChart').getContext('2d');
  new Chart(ctx, {
      type: 'bar',
      data: categoryData,
      options: categoryOptions
  });
</script>


</body>
</html>

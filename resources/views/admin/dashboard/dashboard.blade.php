@extends('components.layouts.admin-default')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="{{ asset('assets/dist/apexcharts.css') }}">
@section('content')
@include('components.includes.admin.navbar')
<main class="content-wrapper">
  <div class="container-fluid py-3">
    <div class="col-12 pl-0 d-flex justify-content-between">
      <div class="heading-top">
        <h1 class="mb-0 pl-0">Dashboard</h1>
        <p class="pl-0">Welcome to Banglz Platform</p>
      </div>
      <div>

      </div>
    </div>
    {{-- cards-section --}}
    <div class="dashbord-card-main row">
      <div class="dashbord-cards col-md-4">
        <div class="card-counter info">
          <i class="fa fa-ticket"></i>
          <span class="count-name">Products</span>
          <span class="count-numbers">{{$productsCount ?? '-'}}</span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-counter info">
          <i class="fa fa-users"></i>
          <span class="count-name">Categories</span>
          <span class="count-numbers">{{$categoryCount ?? '-'}}</span>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card-counter info">
          <i class="fa fa-code-fork"></i>
          <span class="count-name">Collections</span>
          <span class="count-numbers">{{$collectionsCount ?? '-'}}</span>
        </div>
      </div>


    </div>
    {{-- cards-section-ends --}}

    {{-- detail chart sections --}}
    <div class="detail-chart-section row">
        <div class="col-md-12 col-lg-7 mt-3">
            <div class="orders-card-unique">
                <div class="orders-header-unique">
                <div>
                <h1>Orders Details</h1>
                {{-- <div class="orders-meta-unique">Interactive area chart showing order counts across different time granularities. Use controls to switch.</div> --}}
                </div>
                <div class="orders-controls-unique">
                <button class="orders-seg-btn-unique active" data-range="daily" id="btn-daily">Daily</button>
                <button class="orders-seg-btn-unique" data-range="monthly" id="btn-monthly">Monthly</button>
                <button class="orders-seg-btn-unique" data-range="yearly" id="btn-yearly">Yearly</button>
                </div>
                </div>


                <div id="orders-chart-unique"></div>


                <div class="orders-stats-unique" id="statsRow">
                <div class="orders-stat-unique">
                <div class="orders-muted-unique">Total Orders</div>
                <b id="totalOrders">—</b>
                </div>
                <div class="orders-stat-unique">
                <div class="orders-muted-unique">Average</div>
                <b id="avgOrders">—</b>
                </div>
                <div class="orders-stat-unique">
                <div class="orders-muted-unique">Peak</div>
                <b id="peakOrders">—</b>
                </div>
                </div>


                <div class="orders-footer-actions-unique">

                <div style="flex:1"></div>
                </div>
                </div>

        </div>
        <div class="col-md-12 col-lg-5 mt-3">
            <div class="orders-card-unique">
  <div class="orders-header-unique">
    <div>
      <h1>Profit </h1>
      {{-- <div class="orders-meta-unique">Switch between daily, weekly, and monthly profit insights.</div> --}}
    </div>
    <div class="orders-controls-unique">
      <button class="orders-seg-btn-unique active" data-range="daily" id="profit-daily">Daily</button>
      <button class="orders-seg-btn-unique" data-range="weekly" id="profit-weekly">Weekly</button>
      <button class="orders-seg-btn-unique" data-range="monthly" id="profit-monthly">Monthly</button>
    </div>
  </div>

  <div id="profit-chart-unique"></div>

  <div class="orders-stats-unique">
    <div class="orders-stat-unique">
      <div class="orders-muted-unique">Total Profit</div>
      <b id="profit-total">0</b>
    </div>
    <div class="orders-stat-unique">
      <div class="orders-muted-unique">Average</div>
      <b id="profit-avg">0</b>
    </div>
    <div class="orders-stat-unique">
      <div class="orders-muted-unique">Peak</div>
      <b id="profit-peak">0</b>
    </div>
  </div>
</div>

        </div>
    </div>



    {{-- top products --}}

    <div class="top-product container-fluid  pt-3">
      <div class="heading-top top-product-heading">
        <h1>Top Products</h1>
      </div>
      <div class="client-table product-table">
        <table id="detail-table" class="detail-client-table">
          <thead>
            <tr>
              <th class="table-heading">Product Name</th>
              <th class="table-heading">Product Price</th>
              <th class="table-heading">Product Quantity</th>
              <th class="table-heading">Product Category</th>
              <th class="table-heading">Action</th>

            </tr>
          </thead>
          <tbody>
            @if(sizeof($topProducts)>0)
            @foreach($topProducts as $topProduct)
            <tr>
              <td>{{$topProduct['name'] ?? '-'}}</td>
              <td>{{$topProduct['price'] ?? '-'}}</td>
              <td>{{$topProduct['quantity'] ?? '-'}}</td>
              <td>{{$topProduct['category']['name'] ?? '-'}}</td>
              <td>
                <a href="{{ route('product.details', ['id' => $topProduct['id']]) }}">
                  <button type="button" class="btn btn-primary">View</button>
                </a>

                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $topProduct['id'] }})">Delete</button>

<a href="{{ route('admin.product.edit', ['id' => $topProduct->id]) }}">
    <button type="button" class="btn btn-info">Edit</button>
</a>

              </td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>

    {{-- top products-ends --}}

<form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
  </div>
</main>
@endsection
@section('admininsertjavascript')
<script src="{{ asset('assets/dist/apexcharts.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>







<script>
    function generateDailyData(days = 30){
      const series = [];
      const now = new Date();
      for(let i = days - 1; i >= 0; i--){
        const d = new Date(now);
        d.setDate(now.getDate() - i);
        const value = Math.round(60 + Math.sin(i/3.5)*40 + Math.random()*120);
        series.push({ x: d.toISOString().slice(0,10), y: value });
      }
      return series;
    }

    function generateMonthlyData(months = 12){
      const series = [];
      const now = new Date();
      for(let i = months - 1; i >= 0; i--){
        const d = new Date(now.getFullYear(), now.getMonth() - i, 1);
        const value = Math.round(800 + Math.cos(i/2.1)*240 + Math.random()*400);
        series.push({ x: d.toISOString().slice(0,7) + '-01', y: value });
      }
      return series;
    }

    function generateYearlyData(years = 5){
      const series = [];
      const now = new Date();
      for(let i = years - 1; i >= 0; i--){
        const d = new Date(now.getFullYear() - i, 0, 1);
        const value = Math.round(9000 + Math.random()*4000 + (i*300));
        series.push({ x: d.toISOString().slice(0,10), y: value });
      }
      return series;
    }

    const DATA = {
      daily: generateDailyData(30),
      monthly: generateMonthlyData(12),
      yearly: generateYearlyData(5)
    };

    function computeStats(arr){
      const values = arr.map(p=>p.y);
      const total = values.reduce((s,v)=>s+v,0);
      const avg = total / values.length;
      const peak = Math.max(...values);
      return { total, avg: Math.round(avg), peak };
    }

    let smooth = true;
    const options = {
      chart: {
        type: 'area',
        height: 380,
        toolbar:{ show:true }
      },
      series: [{ name: 'Orders', data: DATA.daily }],
      stroke: { curve: 'smooth', width: 2 },
      markers: { size: 4 },
      fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05, stops: [0, 90, 100] } },
      xaxis: { type: 'datetime' },
      yaxis: { decimalsInFloat: 0, title: { text: 'Orders' } },
      tooltip: { x: { format: 'dd MMM yyyy' } },
      dataLabels: { enabled: false },
      responsive: [{
        breakpoint: 640,
        options: { chart: { height: 300 }, markers: { size:3 } }
      }]
    };

    const chart = new ApexCharts(document.querySelector('#orders-chart-unique'), options);
    chart.render();

    function setActiveButton(range){
      document.querySelectorAll('.orders-seg-btn-unique').forEach(b=>{
        b.classList.toggle('active', b.dataset.range === range);
      });
    }

    function updateChart(range){
      const series = [{ name: 'Orders', data: DATA[range] }];
      const xFormat = range === 'daily' ? 'dd MMM yyyy' : (range === 'monthly' ? 'MMM yyyy' : 'yyyy');
      chart.updateOptions({
        series,
        stroke: { curve: smooth ? 'smooth' : 'straight', width:2 },
        xaxis: { type: 'datetime', labels: { datetimeUTC: false }, tooltip: { enabled: true } },
        tooltip: { x: { format: xFormat } }
      });

      const stats = computeStats(DATA[range]);
      document.getElementById('totalOrders').textContent = stats.total.toLocaleString();
      document.getElementById('avgOrders').textContent = stats.avg.toLocaleString();
      document.getElementById('peakOrders').textContent = stats.peak.toLocaleString();
    }

    document.getElementById('btn-daily').addEventListener('click', ()=>{ setActiveButton('daily'); updateChart('daily'); });
    document.getElementById('btn-monthly').addEventListener('click', ()=>{ setActiveButton('monthly'); updateChart('monthly'); });
    document.getElementById('btn-yearly').addEventListener('click', ()=>{ setActiveButton('yearly'); updateChart('yearly'); });

    document.getElementById('toggleSpline').addEventListener('click', ()=>{
      smooth = !smooth;
      chart.updateOptions({ stroke: { curve: smooth ? 'smooth' : 'straight' } });
      document.getElementById('toggleSpline').textContent = smooth ? 'Toggle Smooth Line' : 'Toggle Straight Line';
    });

    document.getElementById('downloadPng').addEventListener('click', ()=>{
      chart.dataURI().then(({ imgURI })=>{
        const link = document.createElement('a');
        link.href = imgURI;
        link.download = 'orders-chart.png';
        document.body.appendChild(link);
        link.click();
        link.remove();
      });
    });

    updateChart('daily');
  </script>

<script>
  // --------- Data Generators ----------
  function generateDailyProfit(days = 30) {
    const data = [];
    const now = new Date();
    for (let i = days - 1; i >= 0; i--) {
      const d = new Date(now);
      d.setDate(now.getDate() - i);
      const val = Math.round(200 + Math.sin(i/3) * 100 + Math.random() * 300);
      data.push({ x: d.toISOString().slice(0,10), y: val });
    }
    return data;
  }

  function generateWeeklyProfit(weeks = 12) {
    const data = [];
    const now = new Date();
    for (let i = weeks - 1; i >= 0; i--) {
      const d = new Date(now);
      d.setDate(now.getDate() - i * 7);
      const val = Math.round(1800 + Math.cos(i/2) * 500 + Math.random() * 700);
      data.push({ x: d.toISOString().slice(0,10), y: val });
    }
    return data;
  }

  function generateMonthlyProfit(months = 12) {
    const data = [];
    const now = new Date();
    for (let i = months - 1; i >= 0; i--) {
      const d = new Date(now.getFullYear(), now.getMonth() - i, 1);
      const val = Math.round(8000 + Math.sin(i/2) * 2000 + Math.random() * 2500);
      data.push({ x: d.toISOString().slice(0,7) + "-01", y: val });
    }
    return data;
  }

  const PROFIT_DATA = {
    daily: generateDailyProfit(30),
    weekly: generateWeeklyProfit(12),
    monthly: generateMonthlyProfit(12),
  };

  // --------- Stats ----------
  function computeStats(arr) {
    const values = arr.map(p => p.y);
    const total = values.reduce((s,v)=>s+v,0);
    const avg = total / values.length;
    const peak = Math.max(...values);
    return { total, avg: Math.round(avg), peak };
  }

  // --------- Chart ----------
  let smoothLine = true;
  const profitOptions = {
    chart: { type: 'area', height: 380, toolbar: { show: false } },
    series: [{ name: 'Profit', data: PROFIT_DATA.daily }],
    stroke: { curve: 'smooth', width: 2 },
    fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.05 } },
    markers: { size: 3 },
    xaxis: { type: 'datetime' },
    yaxis: { title: { text: 'Profit ($)' } },
    tooltip: { x: { format: 'dd MMM yyyy' }, y: { formatter: v => `$${v.toLocaleString()}` } }
  };

  const profitChart = new ApexCharts(document.querySelector("#profit-chart-unique"), profitOptions);

  function updateProfitChart(range) {
    const newSeries = [{ name: 'Profit', data: PROFIT_DATA[range] }];
    const xFormat =
      range === "daily" ? "dd MMM" :
      range === "weekly" ? "dd MMM yyyy" : "MMM yyyy";

    profitChart.updateOptions({
      series: newSeries,
      stroke: { curve: smoothLine ? "smooth" : "straight", width: 2 },
      tooltip: { x: { format: xFormat } }
    });

    const stats = computeStats(PROFIT_DATA[range]);
    document.getElementById("profit-total").textContent = `$${stats.total.toLocaleString()}`;
    document.getElementById("profit-avg").textContent = `$${stats.avg.toLocaleString()}`;
    document.getElementById("profit-peak").textContent = `$${stats.peak.toLocaleString()}`;
  }

  // --------- Init ---------
  profitChart.render().then(() => {
    updateProfitChart("daily");
    setActiveProfitBtn("daily");
  });

  function setActiveProfitBtn(range) {
    document.querySelectorAll(".profit-btn-unique").forEach(btn => {
      btn.classList.toggle("active", btn.dataset.range === range);
    });
  }

  // --------- Listeners ---------
  document.getElementById("profit-daily").addEventListener("click", () => {
    setActiveProfitBtn("daily"); updateProfitChart("daily");
  });
  document.getElementById("profit-weekly").addEventListener("click", () => {
    setActiveProfitBtn("weekly"); updateProfitChart("weekly");
  });
  document.getElementById("profit-monthly").addEventListener("click", () => {
    setActiveProfitBtn("monthly"); updateProfitChart("monthly");
  });
</script>


<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This product will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Use route URL
            const url = "{{ route('product.delete', ':id') }}".replace(':id', id);

            // Optional: Use AJAX for deletion
            fetch(url, {
                method: 'delete',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.status){
                    Swal.fire(
                        'Deleted!',
                        'Product has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload(); // Refresh page
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Something went wrong.',
                        'error'
                    );
                }
            })
            .catch(() => {
                Swal.fire(
                    'Error!',
                    'Something went wrong.',
                    'error'
                );
            });
        }
    });
}




</script>
<script type="text/javascript">
  $(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
      $('#reportrange span').html(start.format('MMM D YY') + ' - ' + end.format('MMM D YY'));
    }

    $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      // ranges: {
      //    'Today': [moment(), moment()],
      //    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      //    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      //    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      //    'This Month': [moment().startOf('month'), moment().endOf('month')],
      //    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      // }
    }, cb);

    cb(start, end);

  });
</script>
<script>
  // $(function() {
  //   $('input[name="daterange"]').daterangepicker({
  //     opens: 'left'
  //   }, function(start, end, label) {
  //     console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  //   });
  // });
</script>
<script>
  $('body').addClass('bg-clr')
</script>
<script>
  $('.sidenav  li:nth-of-type(1)').addClass('active');
</script>

@endsection

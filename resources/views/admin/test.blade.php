
@extends('app')

@section('content')

    <div class="block header-block header-with-bg">
        <div class="row header-with-icon">
            <h2>
                Dashboard</h2>
        </div>
    </div>

    <div class="push-up-block  wide-header row">

    <div class="dashboard-highlight">

        <div class="columns medium-4 small-12">
            <div class="header-description text-center">
                <div class="big-header">
 			
					<span class="spanblock">Last imported on</span>
                    <div class="number big-amount">02</div>
					<span class="spanblock">days ago</span>
					<span class="spanblock">March 15, 2017</span>
				
                </div>
            
            </div>
        </div>

		  <div class="columns medium-4 small-12">
            <div class="header-description text-center">
                <div class="big-header">

                   <span class="spanblock">Last imported on</span>
                     <div class="number big-amount">05</div>
					<span class="spanblock">days ago</span>
					<span class="spanblock">March 15, 2017</span>
		
                </div>
             
            </div>
        </div>

		<div class="columns medium-4 small-12">
            <div class="header-description text-center">
                <div class="big-header">

                   <span class="spanblock">Last imported on</span>
                    <div class="number big-amount">517</div>
					<span class="spanblock">days ago</span>
					<span class="spanblock">March 15, 2017</span>

                </div>
             
            </div>
        </div>

    </div>    

		<div class="clearfix"></div>

		<div class="dashboard-detials">

			<div class="data-import-block text-center">
				<p>Last company data imported: <a href="">http://moldova.yipl.com.np/csv/download.csv</a> </p>
				<span>On March15, 2017</span>
			</div>


			<div class="columns medium-6 small-12">
           <h4>Status of services</h4>
					<li>MongoDB</li>
					<li>NGINX</li>
        </div>

		<div class="columns medium-6 small-12">
           
					<h4>Useful links</h4>
					<ul>
						<li><a href="">View data assessment</a></li>
						<li><a href="">General IT troubleshooting guide</a></li>
					</ul>

              
        </div>

	</div>

    
    </div>

    </div>

	@endsection
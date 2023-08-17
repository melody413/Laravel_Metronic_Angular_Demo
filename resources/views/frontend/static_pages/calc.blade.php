@extends('frontend.master')

@section('title', trans('general.contact_us'))

@section('content')
    <section class="inner_container">
        <div class="container--">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="stand_alone_container--">
                        <h1>{{-- trans('general.contact_us') --}}</h1>
                        <div class="stand_alone_inner">

		<section class="calculate @if($type != "pregnancy-calculator") hidden @endif">
			<div class="cal-table container--">
				<div class="row justify-content-center mb-4">
					<div class="col-md-12 mb-4">
						<h1>حاسبة الحمل والولادة</h1>
						<hr>
					</div>
					<div class="col-md-1">
						<img src="/assets/frontend/images/home/pregnant.png">
					</div>
					<div class="col-md-6">
						<p>حاسبة الحمل والولادة هذه الحاسبة تساعدك على تحديد مراحل الحمل المهمة وموعد الولادة المتوقع</p>
					</div>
				</div>
				<div class="row justify-content-center mb-4">
					<div class="col-md-7">
						<p><strong>تاريخ أول يوم لآخر دورة شهرية</strong></p>
						<div>
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<select id="day-preg" class="form-control">
											<option selected hidden>اليوم</option>
									        <option value="">01</option>
									        <option value="">02</option>
									        <option value="">03</option>
									        <option value="">04</option>
									        <option value="">05</option>
									        <option value="">06</option>
									        <option value="">07</option>
									        <option value="">08</option>
									        <option value="">09</option>
									        <option value="">10</option>
									        <option value="">11</option>
									        <option value="">12</option>
									        <option value="">13</option>
									        <option value="">14</option>
									        <option value="">15</option>
									        <option value="">16</option>
									        <option value="">17</option>
									        <option value="">18</option>
									        <option value="">19</option>
									        <option value="">20</option>
									        <option value="">21</option>
									        <option value="">22</option>
									        <option value="">23</option>
									        <option value="">24</option>
									        <option value="">25</option>
									        <option value="">26</option>
									        <option value="">27</option>
									        <option value="">28</option>
									        <option value="">29</option>
									        <option value="">30</option>
									        <option value="">31</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<select id="month-preg" class="form-control">
											<option selected hidden>الشهر</option>
									        <option value="1">يناير</option>
									        <option value="2">فبراير</option>
									        <option value="3">مارس</option>
									        <option value="4">ابريل</option>
									        <option value="5">مايو</option>
									        <option value="6">يونيو</option>
									        <option value="7">يوليو</option>
									        <option value="8">اغسطس</option>
									        <option value="9">سبتمبر</option>
									        <option value="10">اكتوبر</option>
									        <option value="11">نوفمبر</option>
									        <option value="12">ديسمبر</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<select id="year-preg" class="form-control">
											<option selected hidden>السنة</option>
									        <option value="2022">2022</option>
									        <option value="2023">2023</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<button id="preg-calc" class="btn btn-primary form-control">احسبي</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row result hidden">
					<div class="col-md-12">
						<div class="result-content container--">
							<h3>حاسبة الحمل والولادة</h3>
							<div class="boxes text-center row">
								<div class="col-md-3">
									<div class="box shadow">
										<p>أول موعد للولادة</p>
										<h4 id="first-birth-date">06/09/2020</h4>
									</div>
								</div>
								<div class="col-md-3">
									<div class="box shadow border">
										<p>موعد الولادة المتوقع</p>
										<h4 id="expected-birth-date">06/09/2020</h4>
									</div>
								</div>
								<div class="col-md-3">
									<div class="box shadow">
										<p>آخر موعد للولادة</p>
										<h4 id="last-birth-date">06/09/2020</h4>
									</div>
								</div>
								<div class="col-md-3">
									<div class="box shadow">
										<p>انتى الآن فى</p>
										<h4>
											<span>الاسبوع</span>
											<span id="week-birth">0</span>
											<!--<span>اليوم</span>
											<span id="day-birth">0</span>-->
										</h4>
									</div>
								</div>
							</div>
							<div class="phases text-center row">
								<div class="col-md-4">
									<div class="phase">
										<p>{{ trans('general.phase1') }}</p>
										<h4 id="start-1st">06/09/2020</h4>
									</div>
								</div>
								<div class="col-md-4">
									<div class="phase">
										<p>{{ trans('general.phase2') }}</p>
										<h4 id="start-2nd">06/09/2020</h4>
									</div>
								</div>
								<div class="col-md-4">
									<div class="phase">
										<p>{{ trans('general.phase3') }}</p>
										<h4 id="start-3rd">06/09/2020</h4>
									</div>
								</div>
							</div>
							<h3 class="mb-4">نتائج القياسات الشخصية</h3>
							<table class="table table-hover">
							  	<!-- <caption>List of users</caption> -->
								<thead>
								    <tr>
								      <th scope="col">خطوات</th>
								      <th scope="col">اليوم</th>
								      <th scope="col">أسبوع</th>
								    </tr>
								</thead>
							  	<tbody>
								    <tr>
										<th scope="row">مرحلة تكون الجنين</th>
										<td id="week-2">النتيجة</td>
										<td>2</td>
								 	</tr>
								  	<tr>
								      	<th scope="row">بداية علامات الحمل</th>
								      	<td id="week-4">النتيجة</td>
								      	<td>4</td>
								    </tr>
								    <tr>
								      	<th scope="row">ظهور النبض لدى الجنين وكذلك ظهور أطرافه كبراعم صغيرة</th>
								      	<td id="week-5">النتيجة</td>
								      	<td>5</td>
								    </tr>
								    <tr>
								      	<th scope="row">زيادة فى حجم الرحم وأعضاء الجنين مكتملة بوزن 7 جم تقريباً</th>
								      	<td id="week-10">النتيجة</td>
								      	<td>10</td>
								    </tr>
								    <tr>
								      	<th scope="row">يبدأ رأس الجنين بأخذ الشكل المستدير</th>
								      	<td id="week-12">النتيجة</td>
								      	<td>12</td>
								    </tr>
								    <tr>
								      	<th scope="row">إزدياد فى حجم البطن وبداية نمو شعر الجنين</th>
								      	<td id="week-14">النتيجة</td>
								      	<td>14</td>
								    </tr>
								    <tr>
								      	<th scope="row">يبدأ طفلك الإحساس بالضوء من خلال طبقات جلدك</th>
								      	<td id="week-15">النتيجة</td>
								      	<td>15</td>
								    </tr>
								    <tr>
								      	<th scope="row">معرفة نوع الجنين</th>
								      	<td id="week-16">النتيجة</td>
								      	<td>16</td>
								    </tr>
								    <tr>
								      	<th scope="row">تصبح حركات الجنين محسوسة وبداية مرحلة تكوين الأسنان</th>
								      	<td id="week-18">النتيجة</td>
								      	<td>18</td>
								    </tr>
								    <tr>
								      	<th scope="row">يبدأ الجنين الإحساس بالأصوات الخارجية</th>
								      	<td id="week-19">النتيجة</td>
								      	<td>19</td>
								    </tr>
								    <tr>
								      	<th scope="row">يصل وزن الجنين حوالى 500 جم</th>
								      	<td id="week-23">النتيجة</td>
								      	<td>23</td>
								    </tr>
								    <tr>
								      	<th scope="row">يبدأ الجنين فى مرحلة التنفس</th>
								      	<td id="week-27">النتيجة</td>
								      	<td>27</td>
								    </tr>
								    <tr>
								      	<th scope="row">يبدأ الجنين بأخذ وضعية الولادة وذلك بتوجيه الرأس الى أسفل الرحم</th>
								      	<td id="week-32">النتيجة</td>
								      	<td>32</td>
								    </tr>
								    <tr>
								      	<th scope="row">يزداد وزن الجنين بمعدل 100 جم كل ثلاثة أيام</th>
								      	<td id="week-37">النتيجة</td>
								      	<td>37</td>
								    </tr>
								    <tr>
								      	<th scope="row">أنت الآن بإنتظار مولودك الجديد</th>
								      	<td id="week-40">النتيجة</td>
								      	<td>40</td>
								    </tr>
							  	</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section> <!--حاسبة الحمل والولادة -->

		<section class="calculate @if($type != "bmr-calculator") hidden @endif">
			<div class="cal-table container--">
				<div class="row mb-4">
					<div class="col-md-1">
						<img src="https://hmp-doctorak.s3.us-east-2.amazonaws.com/%D8%A7%D9%84%D8%B3%D8%B9%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%AD%D8%B1%D8%A7%D8%B1%D9%8A%D9%87.png">
					</div>
					<div class="col-md-11 mb-4">
						<h1>حاسبة السعرات الحرارية</h1>
						<hr>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-md-4">
						<!-- <p><strong>تاريخ أول يوم لآخر دورة شهرية</strong></p> -->
						<div>
							<div class="form-group">
								<label>الطول</label>
								<input id="heat-height" type="text" name="" class="form-control">
							</div>
							<div class="form-group">
								<label>الوزن</label>
								<input id="heat-weight" type="text" name="" class="form-control">
							</div>
							<div class="form-group">
								<label>السن</label>
								<input id="heat-age" type="text" name="" class="form-control">
							</div>
							<div class="form-group">
								<button id="heat-btn" class="btn btn-primary form-control">احسب</button>
							</div>
						</div>
					</div>
					<div class="col-md-8"> 
						<div class="result-heat hidden">
							<div class="boxes">
								<h4 class="mb-4">احتياجاتك من السعرات الحرارية اليومين = <span class="green-bold">1439</span> سعر / اليوم</h4>
								<div class="box">
									<p>Daily calorie needs based on activity level</p>
									<table class="table table-hover text-right">
									  	<!-- <caption>List of users</caption> -->
										<thead>
										    <tr>
										      <th scope="col">Activity Level</th>
										      <th scope="col">Calorie</th>
										    </tr>
										</thead>
									  	<tbody>
										    <tr>
										      	<th scope="row">Sedentary: little or no exercise</th>
										      	<td>1,926
												</td>
										    </tr>
										    <tr>
										      	<th scope="row">Exercise 1-3 times/week</th>
										      	<td>2,207
												</td>
										    </tr>
										    <tr>
										      	<th scope="row">Exercise 4-5 times/week</th>
										      	<td>2,351
												</td>
										    </tr>
										    <tr>
										      	<th scope="row">Daily exercise or intense exercise 3-4 times/week</th>
										      	<td>2,488
												</td>
										    </tr>
										    <tr>
										      	<th scope="row">Intense exercise 6-7 times/week</th>
										      	<td>2,769
												</td>
										    </tr>
										    <tr>
										      	<th scope="row">Very intense exercise daily, or physical job</th>
										      	<td>3,050
												</td>
										    </tr>
									  	</tbody>
									</table>	
									<div class="text-right">
										<p>Exercise: 15-30 minutes of elevated heart rate activity.</p>
										<p>Intense exercise: 45-120 minutes of elevated heart rate activity.</p>
										<p>Very intense exercise: 2+ hours of elevated heart rate activity.</p>	
									</div>					
								</div>
							</div>
						</div>
					</div>	
				</div>				
			</div>
		</section>  <!-- حاسبة السعرات الحرارية -->

		<section class="calculate @if($type != "bmi-calculator") hidden @endif">
			<div class="cal-table container--">
				<div class="row mb-4">
					<div class="col-md-1">
						<img src="/assets/frontend/images/home/body.png">
					</div>
					<div class="col-md-11 mb-4">
						<h1>حاسبة الجسم</h1>
						<hr>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-md-4">
						<!-- <p><strong>تاريخ أول يوم لآخر دورة شهرية</strong></p> -->
						<div>
							<div class="form-group">
								<label>الطول</label>
								<input id="body-height" type="text" name="" class="form-control">
							</div>
							<div class="form-group">
								<label>الوزن</label>
								<input id="body-weight" type="text" name="" class="form-control">
							</div>
							<div class="form-group">
								<label>السن</label>
								<input id="body-age" type="text" name="" class="form-control">
							</div>
							<div class="form-group">
								<label>ذكر</label>
								<input type="checkbox" name="" class="ml-4">
								<label>انثى</label>
								<input type="checkbox" name="" class="ml-4">
							</div>
							<div class="form-group">
								<button id="body-btn" class="btn btn-primary form-control">احسب</button>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="result-body hidden">
							<div class="boxes">
								<div class="box text-right">
									<h5 class="mb-4">مؤشر كتلة الجسم الحالى = <span id="body-bmi" class="green-bold">25.77</span></h5>
									<h5 class="mb-4">معدل مؤشر كتلة الجسم الصحي = <span class="green-bold">24.99	 18.49</span></h5>
									<h5>الوضع الصحي</h5><hr>
									<h5>يفضل أن يكون وزنك بين <span id="body-weight-avg" style="color: green"> 68.16 لـ 92.12</span></h5>
									<div class="bmi-bar container--">
										<div class="row">
											<div class="col-12">
												<div class="background">
													<p class="res" style="left: 20%;">120</p>
												</div>
											</div>
												
											<div class="col">
												
												<p>وزن ناقص</p>
											</div>
											<div class="col">
												
												<p>وزن صحى</p>
											</div>
											<div class="col">
												
												<p>وزن زائد</p>
											</div>
											<div class="col">
												
												<p>سمنة</p>
											</div>
											<div class="col">
												
												<p>سمنة مفرطة</p>
											</div>
										</div>
									</div>
									<div class="text-left">
										<p><strong>According to most criteria accepted around the world:</strong></p>
										<p>A BMI of <span style="color: red"> 18.49 </span> or below means a person is underweight</p>
										<p>A BMI of <span style="color: green"> 18.5 to 24.99 </span> means they are of normal weight</p>
										<p>A BMI of <span style="color: red"> 25 to 29.99 </span> means they are overweight</p>
										<p>A BMI of <span style="color: red">  30 or more </span> means they are obese</p>										
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>				
			</div>
		</section> <!-- حاسبة الجسم -->

		<section class="calculate @if($type != "period-calculator") hidden @endif">
			<div class="cal-table container--">
				<div class="row justify-content-center mb-4">
					<div class="col-md-12 mb-4">
						<h1>حاسبة الدورة الشهرية</h1>
						<hr>
					</div>
					<div class="col-md-1">
						<img src="/assets/frontend/images/home/لاباضه.png">
					</div>
					<div class="col-md-6">
						<p>حاسبة الدورة الشهرية</p>
					</div>
				</div>
				<div class="row justify-content-center mb-4">
					<div class="col-md-7">
						<!-- <p><strong>تاريخ أول يوم لآخر دورة شهرية</strong></p> -->
						<div>
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<label>تاريخ اخر دورة شهرية</label>
										<input id="period-lastdate" type="text" name="" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>عدد الايام</label>
										<input id="period-days" type="text" name="" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>المتوسط</label>
										<input id="period-med" type="text" name="" class="form-control">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<button id="period-btn" class="btn btn-primary form-control">احسبي</button>
									</div>
								</div>
							</div>
						</div>
						<div class="container--">
							<div class="row">
								<div class="col-md-6 result-period hidden">
									<div class="boxes">
										<div class="box">
											<table class="table table-hover text-center">
											  	<!-- <caption>List of users</caption> -->
												<thead>
												    <tr>
												      <th scope="col" colspan="2">Period</th>
												    </tr>
												</thead>
											  	<tbody >
												    <tr>
												      	<td>2019-06-01</td>
												      	<td>2019-05-26</td>
												    </tr>
												    <tr>
												      	<td>2019-06-01</td>
												      	<td>2019-05-26</td>
												    </tr>
												    <tr>
												      	<td>2019-06-01</td>
												      	<td>2019-05-26</td>
												    </tr>
												    <tr>
												      	<td>2019-06-01</td>
												      	<td>2019-05-26</td>
												    </tr>
												    <tr>
												      	<td>2019-06-01</td>
												      	<td>2019-05-26</td>
												    </tr>
											  	</tbody>
											</table>											
										</div>
									</div>
								</div>

								<div class="col-md-6 result-period hidden"">
									<div class="boxes">
										<div class="box">
											<table class="table table-hover text-center">
											  	<!-- <caption>List of users</caption> -->
												<thead>
												    <tr>
												      <th scope="col" colspan="2">Most Probable Ovulation Days</th>
												    </tr>
												</thead>
											  	<tbody >
												    <tr>
												      	<td>2019-06-01</td>
												      	<td>2019-05-26</td>
												    </tr>
												    <tr>
												      	<td>2019-06-01</td>
												      	<td>2019-05-26</td>
												    </tr>
												    <tr>
												      	<td>2019-06-01</td>
												      	<td>2019-05-26</td>
												    </tr>
												    <tr>
												      	<td>2019-06-01</td>
												      	<td>2019-05-26</td>
												    </tr>
												    <tr>
												      	<td>2019-06-01</td>
												      	<td>2019-05-26</td>
												    </tr>
											  	</tbody>
											</table>											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>				
			</div>
		</section>  <!-- حاسبة الدورة الشهرية -->

		<section class="calculate @if($type != "ovulation-calculator") hidden @endif">
			<div class="cal-table container--">
				<div class="row justify-content-center mb-4">
					<div class="col-md-12 mb-4">
						<h1>حاسبة التبويض</h1>
						<hr>
					</div>
					<div class="col-md-1">
						<img src="https://hmp-doctorak.s3.us-east-2.amazonaws.com/%D8%AA%D8%B7%D9%88%D8%B1-%D8%A7%D9%84%D8%AC%D9%86%D9%8A%D9%86.png">
					</div>
					<div class="col-md-6">
						<p>حاسبة الدورة الشهرية</p>
					</div>
				</div>
				<div class="row justify-content-center mb-4">
					<div class="col-md-7">
						<!-- <p><strong>تاريخ أول يوم لآخر دورة شهرية</strong></p> -->
						<div>
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<label>تاريخ اخر دورة شهرية</label>
										<input id="egg-lastdate" type="text" name="" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>عدد الايام</label>
										<input id="egg-days" type="text" name="" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>المتوسط</label>
										<input id="egg-med" type="text" name="" class="form-control">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<button id="egg-btn" class="btn btn-primary form-control">احسبي</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="container-- result-egg hidden mt-4">
							<div class="row">
								<div class="col">
									<div class="boxes text-center">
										<div class="box" style="min-height: auto">
											<h4>31</h4>
											<p>يوليو 2020</p>
										</div>
										<p>بداية الحيض</p>
									</div>
								</div>
								<div class="col">
									<div class="boxes text-center">
										<div class="box" style="min-height: auto">
											<h4>31</h4>
											<p>يوليو 2020</p>
										</div>
										<p>بداية الخصوبة</p>
									</div>
								</div>
								<div class="col">
									<div class="boxes text-center">
										<div class="box" style="min-height: auto">
											<h4>31</h4>
											<p>يوليو 2020</p>
										</div>
										<p>يوم الإباضة</p>
									</div>
								</div>
								<div class="col">
									<div class="boxes text-center">
										<div class="box" style="min-height: auto">
											<h4>31</h4>
											<p>يوليو 2020</p>
										</div>
										<p>نهاية الخصوبة</p>
									</div>
								</div>
								<div class="col">
									<div class="boxes text-center">
										<div class="box" style="min-height: auto">
											<h4>31</h4>
											<p>يوليو 2020</p>
										</div>
										<p>فضل يوم لإختبار الحمل</p>
									</div>
								</div>
								<div class="col">
									<div class="boxes text-center">
										<div class="box" style="min-height: auto">
											<h4>31</h4>
											<p>يوليو 2020</p>
										</div>
										<p>يوم الولادة المتوقع</p>
									</div>
								</div>
							</div>
						</div>
					</div>			
				</div>	
			</div>
		</section> <!-- حاسبة التبويض -->

		<!-- JS -->
		<script src="/calc/js/jquery-3.4.1.min.js"></script>
		<script src="/calc/js/jquery-dateformat.min.js"></script>
		<script src="/calc/js/popper.min.js"></script>
		<script src="/calc/js/bootstrap.min.js"></script>
		<script src="/calc/js/aos.js"></script>	
		{{-- <script src="/calc/js/plugin.js"></script> --}}

<script>
	$("#heat-btn").click(function(){
		$(".result-heat").show();
	});

	$("#body-btn").click(function(){
		height = $("#body-height").val();
		weight = $("#body-weight").val();
		weight_avg_min = 18.49*(height/100)*2;
		weight_avg_max = 24.99*(height/100)*2;
		$(".result-body").show();
		$("#body-bmi").html(weight/((height/100)*2));
		$("#body-weight-avg").html(weight_avg_min + "ل "+ weight_avg_max);
	});

	$("#period-btn").click(function(){
		lastdate = $("#period-lastdate").val();
		days = $("#period-days").val();
		med = $("#period-med").val();

		$(".result-period").show();
	});

	$("#egg-btn").click(function(){
		lastdate = $("#egg-lastdate").val();
		days = $("#egg-days").val();
		med = $("#egg-med").val();

		$(".result-egg").show();
	});

	$("#preg-calc").click(function(){
		day = $("#day-preg option:selected").html();
		month = $("#month-preg option:selected").val();
		year = $("#year-preg option:selected").html();

		if( day =="اليوم" || month =="الشهر" || year =="السنة" ) {
			alert("من فضلك اختر التاريخ")
		} else {
			selected_date1 = new Date(year, month-1, day);
			selected_date2 = new Date(year, month-1, day);
			selected_date3 = new Date(year, month-1, day);
			selected_date4 = new Date(year, month-1, day);
			selected_date5 = new Date(year, month-1, day);
			selected_date6 = new Date(year, month-1, day);
			selected_date7 = new Date(year, month-1, day);
			currentDate = new Date();

			$(".row.result").show();

			$("#first-birth-date").html($.format.date(selected_date1.setDate(selected_date1.getDate() + (7*37)), "dd/MM/yyyy") );
			$("#expected-birth-date").html($.format.date(selected_date2.setDate(selected_date2.getDate() + (7*38)), "dd/MM/yyyy") );
			$("#last-birth-date").html($.format.date(selected_date3.setDate(selected_date3.getDate() + (7*40)), "dd/MM/yyyy") );
			$("#week-birth").html( Math.round( (new Date( currentDate - selected_date4 )) /1000/60/60/24/7 ));
			//$("#day-birth").html();
			$("#start-1st").html($.format.date(selected_date5.setDate(selected_date5.getDate() + 1), "dd/MM/yyyy") );
			$("#start-2nd").html($.format.date(selected_date6.setDate(selected_date6.getDate() + 1 + (14*7)), "dd/MM/yyyy") );
			$("#start-3rd").html($.format.date(selected_date7.setDate(selected_date7.getDate() + 1 + (27*7)), "dd/MM/yyyy") );

			$("#week-2").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (2*7)), "dd/MM/yyyy") );
			$("#week-4").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (4*7)), "dd/MM/yyyy") );
			$("#week-5").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (5*7)), "dd/MM/yyyy") );
			$("#week-10").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (10*7)), "dd/MM/yyyy") );
			$("#week-12").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (12*7)), "dd/MM/yyyy") );
			$("#week-14").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (14*7)), "dd/MM/yyyy") );
			$("#week-15").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (15*7)), "dd/MM/yyyy") );
			$("#week-16").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (16*7)), "dd/MM/yyyy") );
			$("#week-18").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (18*7)), "dd/MM/yyyy") );
			$("#week-19").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (19*7)), "dd/MM/yyyy") );
			$("#week-23").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (23*7)), "dd/MM/yyyy") );
			$("#week-27").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (27*7)), "dd/MM/yyyy") );
			$("#week-32").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (32*7)), "dd/MM/yyyy") );
			$("#week-37").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (37*7)), "dd/MM/yyyy") );
			$("#week-40").html($.format.date(new Date(year, month-1, day).setDate(new Date(year, month-1, day).getDate() + (40*7)), "dd/MM/yyyy") );

			//alert(selected_date1);
		}

	});

</script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
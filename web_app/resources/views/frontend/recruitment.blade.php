@extends('layouts.frontend')

@section('title', 'Recruitment Opportunities')

@section('content')
<div class="container py-4 py-lg-5">
    <h1 class="h2 text-center mb-4">Join the GreenTech Team!</h1>
    <p class="lead text-center text-muted mb-5">
        We are constantly looking for talented and passionate individuals to help us build the future of IoT agriculture.
    </p>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        
        {{-- Vị trí 1: IoT Software Engineer --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h3 class="h4 card-title text-primary">IoT Software Engineer (Backend/Firmware)</h3>
                    <span class="badge bg-success mb-3">Full-time</span>
                    <p class="card-text text-muted">
                        Design and implement robust firmware for microcontrollers and develop scalable cloud infrastructure for data processing.
                    </p>
                    <ul class="list-unstyled mb-0 small">
                        <li><i class="ci-check text-success me-2"></i>Experience with C/C++ or Python.</li>
                        <li><i class="ci-check text-success me-2"></i>Knowledge of MQTT, AWS IoT, or Azure IoT Hub.</li>
                    </ul>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="#" class="btn btn-link px-0">Apply Now <i class="ci-arrow-right fs-base ms-1"></i></a>
                </div>
            </div>
        </div>
        
        {{-- Vị trí 2: Agricultural Data Scientist --}}
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h3 class="h4 card-title text-primary">Agricultural Data Scientist</h3>
                    <span class="badge bg-info mb-3">Remote</span>
                    <p class="card-text text-muted">
                        Analyze sensor data, develop predictive models for crop health, and optimize irrigation schedules.
                    </p>
                    <ul class="list-unstyled mb-0 small">
                        <li><i class="ci-check text-success me-2"></i>Proficiency in R or Python (Pandas/NumPy).</li>
                        <li><i class="ci-check text-success me-2"></i>Background in agronomy or environmental science is a plus.</li>
                    </ul>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="#" class="btn btn-link px-0">Apply Now <i class="ci-arrow-right fs-base ms-1"></i></a>
                </div>
            </div>
        </div>

    </div>
    
    <div class="text-center mt-5">
        <p class="text-muted">Can't find a suitable position? Send us your CV anyway!</p>
        <a href="{{ route('frontend.contact') }}" class="btn btn-outline-primary rounded-pill">Contact HR Team</a>
    </div>

</div>
@endsection
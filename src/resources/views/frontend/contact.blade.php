@extends('layouts.frontend')

@section('title', 'Contact Us')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="row">
        
        {{-- Contact Information --}}
        <div class="col-lg-5 mb-5 mb-lg-0">
            <h1 class="h2 mb-4">Get in Touch</h1>
            <p class="text-muted mb-4">
                We are ready to answer any questions about our IoT solutions or agricultural technology.
            </p>
            
            <ul class="list-unstyled mb-4">
                <li class="d-flex align-items-center mb-3">
                    <i class="ci-chat text-primary fs-lg me-3"></i>
                    <div>
                        <strong class="d-block">Sales Support:</strong>
                        <a href="mailto:sales@greentech.com">sales@greentech.com</a>
                    </div>
                </li>
                <li class="d-flex align-items-center mb-3">
                    <i class="ci-gear text-primary fs-lg me-3"></i>
                    <div>
                        <strong class="d-block">Technical Support:</strong>
                        <a href="mailto:support@greentech.com">support@greentech.com</a>
                    </div>
                </li>
                <li class="d-flex align-items-center mb-3">
                    <i class="ci-phone text-primary fs-lg me-3"></i>
                    <div>
                        <strong class="d-block">Phone:</strong>
                        <a href="tel:+84123456789">+84 123 456 789</a> (Mon - Fri, 9am - 5pm)
                    </div>
                </li>
            </ul>

            <h6 class="mb-3">Our Office</h6>
            <p class="text-muted small">
                GreenTech HQ<br>
                123 Smart Farm Lane, An Giang, Vietnam
            </p>
            {{-- Thêm map nhúng nếu cần [Image of office location map]--}}
        </div>
        
        {{-- Contact Form --}}
        <div class="col-lg-7">
            <div class="card shadow-lg p-4 p-md-5">
                <h4 class="mb-4">Send Us a Message</h4>
                <form class="row g-4" action="#" method="POST">
                    @csrf
                    
                    <div class="col-md-6">
                        <label for="contact-name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" id="contact-name" name="name" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="contact-email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" id="contact-email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="col-12">
                        <label for="contact-subject" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" id="contact-subject" name="subject" class="form-control" required>
                    </div>
                    
                    <div class="col-12">
                        <label for="contact-message" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea id="contact-message" name="message" class="form-control" rows="5" required></textarea>
                    </div>
                    
                    <div class="col-12 pt-2">
                        <button type="submit" class="btn btn-primary rounded-pill">Submit Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
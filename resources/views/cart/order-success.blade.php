<x-laptop-layout>
    <x-slot name="title">
        Đặt hàng thành công
    </x-slot>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg" style="border-radius: 10px; overflow: hidden;">
                    <!-- Success Header -->
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 50px 30px; text-align: center;">
                        <div style="font-size: 60px; margin-bottom: 20px;">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <h1 style="margin: 0 0 10px 0; font-size: 32px;">Đặt hàng thành công!</h1>
                        <p style="margin: 0; font-size: 16px; opacity: 0.9;">Cảm ơn bạn đã tin tưởng cửa hàng chúng tôi</p>
                    </div>

                    <!-- Content -->
                    <div style="padding: 40px 30px;">
                        <!-- Success Message -->
                        <div style="background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 6px; padding: 20px; margin-bottom: 30px; color: #155724;">
                            <i class="fa fa-info-circle mr-2"></i>
                            <strong>Thông báo:</strong> Xác nhận đơn hàng của bạn đã được gửi đến email. Vui lòng kiểm tra hộp thư đến hoặc thư rác.
                        </div>

                        <!-- Order Info -->
                        <div style="background-color: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #667eea;">
                            <h4 style="margin-top: 0; color: #667eea;">📋 Thông tin đơn hàng</h4>
                            
                            <div style="margin: 15px 0;">
                                <p style="margin: 10px 0;">
                                    <span style="font-weight: bold;">Tên khách hàng:</span>
                                    <span>{{ Auth::user()->name }}</span>
                                </p>
                                <p style="margin: 10px 0;">
                                    <span style="font-weight: bold;">Email:</span>
                                    <span>{{ Auth::user()->email }}</span>
                                </p>
                                <p style="margin: 10px 0;">
                                    <span style="font-weight: bold;">Mã đơn hàng:</span>
                                    <span style="background-color: #e7f3ff; padding: 5px 10px; border-radius: 4px; font-family: monospace;">
                                        #{{ date('YmdHis') }}-{{ Auth::user()->id }}
                                    </span>
                                </p>
                                <p style="margin: 10px 0;">
                                    <span style="font-weight: bold;">Ngày đặt:</span>
                                    <span>{{ date('d/m/Y H:i:s') }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Next Steps -->
                        <div style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 6px; padding: 20px; margin-bottom: 30px;">
                            <h5 style="margin-top: 0; color: #856404;">📝 Các bước tiếp theo</h5>
                            <ol style="margin: 0; padding-left: 20px; color: #856404;">
                                <li style="margin: 8px 0;">Kiểm tra email để xem chi tiết đơn hàng</li>
                                <li style="margin: 8px 0;">Chúng tôi sẽ liên hệ sớm để xác nhận giao hàng</li>
                                <li style="margin: 8px 0;">Thanh toán theo phương thức bạn đã chọn</li>
                                <li style="margin: 8px 0;">Nhận hàng tại địa chỉ của bạn</li>
                            </ol>
                        </div>

                        <!-- Contact Info -->
                        <div style="background-color: #e3f2fd; border-left: 4px solid #2196f3; padding: 20px; border-radius: 6px; margin-bottom: 30px;">
                            <h5 style="margin-top: 0; color: #1976d2;">📞 Liên hệ hỗ trợ</h5>
                            <p style="margin: 10px 0;">
                                <span style="font-weight: bold;">Email:</span>
                                <span>kiennv_htttql@hub.edu.vn</span>
                            </p>
                            <p style="margin: 10px 0;">
                                <span style="font-weight: bold;">Hotline:</span>
                                <span>0123 456 789</span>
                            </p>
                            <p style="margin: 10px 0; font-size: 14px; color: #666;">
                                <i class="fa fa-clock-o mr-1"></i>
                                Giờ làm việc: 8:00 AM - 9:00 PM (Thứ 2 - Chủ Nhật)
                            </p>
                        </div>

                        <!-- Actions -->
                        <div style="text-align: center; margin-top: 40px;">
                            <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 12px 40px; font-size: 15px; margin-right: 10px;">
                                <i class="fa fa-shopping-cart mr-2"></i>Tiếp tục mua hàng
                            </a>
                            <a href="{{ route('cart.view') }}" class="btn btn-outline-primary" style="padding: 12px 40px; font-size: 15px;">
                                <i class="fa fa-arrow-left mr-2"></i>Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div style="margin-top: 30px; padding: 20px; background-color: #f9f9f9; border-radius: 8px; text-align: center;">
                    <p style="margin: 0; color: #666; font-size: 14px;">
                        <i class="fa fa-shield mr-2" style="color: #28a745;"></i>
                        Chúng tôi bảo mật thông tin của bạn và tuân thủ chính sách quyền riêng tư.
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-laptop-layout>

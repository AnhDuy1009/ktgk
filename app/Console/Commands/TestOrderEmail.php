<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class TestOrderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test-order {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi email test xác nhận đặt hàng';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Dữ liệu test
        $cartItems = [
            1 => [
                'name' => 'Laptop Dell 16 DC16250 - 71092481 ( Core 5-120U ) (Đen)',
                'quantity' => 1,
                'price' => 28990000
            ],
            2 => [
                'name' => 'Laptop Lenovo ThinkPad X1 Carbon',
                'quantity' => 2,
                'price' => 25000000
            ]
        ];
        
        $totalPrice = 28990000 + (25000000 * 2);
        $paymentMethod = 'chuyen_khoan';
        $userName = 'Khách hàng test';
        
        try {
            Mail::to($email)->send(new OrderConfirmation(
                $cartItems,
                $totalPrice,
                $paymentMethod,
                $userName,
                $email
            ));
            
            $this->info('✓ Email test đã được gửi thành công đến: ' . $email);
            $this->line('Vui lòng kiểm tra hộp thư đến của bạn.');
        } catch (\Exception $e) {
            $this->error('✗ Lỗi khi gửi email: ' . $e->getMessage());
        }
    }
}

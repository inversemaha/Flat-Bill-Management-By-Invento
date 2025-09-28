<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bill Payment Received</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .payment-confirmation {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 25px;
            margin: 20px 0;
            text-align: center;
        }
        .payment-confirmation h2 {
            margin: 0 0 10px 0;
            color: #155724;
            font-size: 20px;
        }
        .bill-details {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .detail-value {
            color: #6c757d;
        }
        .amount-highlight {
            font-size: 24px;
            font-weight: 700;
            color: #28a745;
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8fff9;
            border: 2px dashed #28a745;
            border-radius: 8px;
        }
        .property-info {
            background-color: #e8f4fd;
            border-left: 4px solid #0066cc;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 6px 6px 0;
        }
        .tenant-info {
            background-color: #f0f8ff;
            border-left: 4px solid #4CAF50;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 6px 6px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            background-color: #d4edda;
            color: #155724;
        }
        .checkmark {
            font-size: 48px;
            color: #28a745;
        }
        @media (max-width: 600px) {
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
            }
            .detail-value {
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>✅ Payment Received</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">{{ $billMonth }} - {{ $category->name }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear <strong>{{ $houseOwner->name }}</strong>,</p>
            
            <p>Great news! A bill payment has been successfully received from your tenant. Here are the payment details:</p>

            <!-- Payment Confirmation -->
            <div class="payment-confirmation">
                <div class="checkmark">✓</div>
                <h2>Payment Confirmed!</h2>
                <p style="margin: 0; color: #155724; font-size: 16px;">
                    The bill has been marked as <strong>PAID</strong>
                </p>
            </div>

            <!-- Property Information -->
            <div class="property-info">
                <h3 style="margin: 0 0 10px 0; color: #0066cc;">🏢 Property Details</h3>
                <p style="margin: 5px 0;"><strong>Building:</strong> {{ $building->name }}</p>
                <p style="margin: 5px 0;"><strong>Flat:</strong> {{ $flat->flat_number }}</p>
                <p style="margin: 5px 0;"><strong>Address:</strong> {{ $building->address }}, {{ $building->city }}</p>
            </div>

            <!-- Tenant Information -->
            @if($tenant)
            <div class="tenant-info">
                <h3 style="margin: 0 0 10px 0; color: #4CAF50;">👤 Tenant Information</h3>
                <p style="margin: 5px 0;"><strong>Name:</strong> {{ $tenant->name }}</p>
                <p style="margin: 5px 0;"><strong>Email:</strong> {{ $tenant->email }}</p>
                <p style="margin: 5px 0;"><strong>Phone:</strong> {{ $tenant->phone }}</p>
            </div>
            @endif

            <!-- Bill Details -->
            <div class="bill-details">
                <h3 style="margin: 0 0 15px 0; color: #495057;">📋 Payment Details</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Bill Category:</span>
                    <span class="detail-value">{{ $category->name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Billing Period:</span>
                    <span class="detail-value">{{ $billMonth }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Base Amount:</span>
                    <span class="detail-value">{{ \App\Helpers\CurrencyHelper::format($bill->amount) }}</span>
                </div>
                
                @if($bill->due_amount > 0)
                <div class="detail-row">
                    <span class="detail-label">Previous Dues Cleared:</span>
                    <span class="detail-value">{{ \App\Helpers\CurrencyHelper::format($bill->due_amount) }}</span>
                </div>
                @endif
                
                <div class="detail-row">
                    <span class="detail-label">Payment Status:</span>
                    <span class="detail-value">
                        <span class="status-badge">Paid</span>
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Payment Date:</span>
                    <span class="detail-value" style="color: #28a745; font-weight: 600;">{{ $paidDate }}</span>
                </div>
            </div>

            <!-- Total Amount Highlight -->
            <div class="amount-highlight">
                Amount Received: {{ $formattedAmount }}
            </div>

            @if($bill->payment_details)
            <div style="background-color: #e7f3ff; border-left: 4px solid #007bff; padding: 15px; margin: 20px 0; border-radius: 0 6px 6px 0;">
                <h4 style="margin: 0 0 10px 0; color: #004085;">💳 Payment Details</h4>
                <p style="margin: 0; color: #004085;">{{ $bill->payment_details }}</p>
            </div>
            @endif

            @if($bill->notes)
            <div style="background-color: #fff9c4; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 0 6px 6px 0;">
                <h4 style="margin: 0 0 10px 0; color: #856404;">📝 Notes</h4>
                <p style="margin: 0; color: #856404;">{{ $bill->notes }}</p>
            </div>
            @endif

            <div style="margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 6px; text-align: center;">
                <p style="margin: 0 0 10px 0; font-weight: 600; color: #495057;">💡 Next Steps</p>
                <p style="margin: 0; font-size: 14px; color: #6c757d;">
                    The payment has been automatically recorded in your system.<br>
                    You can view this transaction in your FlatManager dashboard.
                </p>
            </div>

            <!-- Admin Notification (if sent to admin) -->
            @if(request()->routeIs('admin.*'))
            <div style="margin-top: 20px; padding: 15px; background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 6px;">
                <p style="margin: 0; color: #856404; font-size: 14px;">
                    <strong>Admin Notification:</strong> This payment was processed for {{ $houseOwner->name }}'s property.
                </p>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0;">This is an automated notification from FlatManager System.</p>
            <p style="margin: 5px 0 0 0;">Payment processed on {{ now()->format('M d, Y \a\t g:i A') }}</p>
        </div>
    </div>
</body>
</html>
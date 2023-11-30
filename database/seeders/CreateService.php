<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateService extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['service_name' => 'Xét nghiệm đường huyết', 'price' => '100000', 'additional_information' => '[{"key":"Glucose (Enzymatic Color)","unit_value":"mmol/L","reference_value":"3.9 - 6.4","value":""},{"key":"Urea (Kinetic Color)","unit_value":"mmol/L","reference_value":"1.7 - 8.3","value":""},{"key":"Creatinine (Kinetic Color)","unit_value":"umol/L","reference_value":"44 - 80","value":""},{"key":"eGFR/MDRD","unit_value":"mL","reference_value":"> 1.7","value":""},{"key":"Total Cholesterol (Enzymatic Color)","unit_value":"mmol/L","reference_value":"3.9 - 5.2","value":""},{"key":"HDL Cholesterol","unit_value":"mmol/L","reference_value":"≥ 0.90","value":""},{"key":"LDL Cholesterol","unit_value":"mmol/L","reference_value":"≤ 3.40","value":""},{"key":"Triglycerides (Enzymatic Color)","unit_value":"mmol/L","reference_value":"0.46 - 1.88","value":""},{"key":"Điện giải đồ Na","unit_value":"mmol/L","reference_value":"135 - 150","value":""},{"key":"Điện giải đồ K","unit_value":"mmol/L","reference_value":"3.5 - 5.1","value":""},{"key":"Điện giải đồ CL","unit_value":"mmol/L","reference_value":"96 - 107","value":""},{"key":"AST (Kinetic UV, IFCC)","unit_value":"U/L","reference_value":"31","value":""},{"key":"ALT (Kinetic UV, IFCC)","unit_value":"U/L","reference_value":"31","value":""}]', 'driver_test' => 'Architect'],
            ['service_name' => 'Xét nghiệm máu', 'price' => '200000', 'additional_information' => '[{"key":"RBC (Số lượng hồng cầu","unit_value":"T/L","reference_value":"4.2 - 5.8","value":""},{"key":"HGB (Lượng bạch huyết sắc tố)","unit_value":"g/L","reference_value":"135 - 160","value":""},{"key":"HCT (Thế tích khối hồng cầu)","unit_value":"L/L","reference_value":"0.38 - 0.55","value":""},{"key":"MVC (Thể tích TB HC)","unit_value":"fL","reference_value":"80 - 100","value":""},{"key":"MCH (Lượng HST TB HC)","unit_value":"pg","reference_value":"26 - 34","value":""},{"key":"MCHC (Nồng độ HST TB HC)","unit_value":"g/L","reference_value":"315 - 360","value":""},{"key":"RDW (Dải phân bố KT HC)","unit_value":"%","reference_value":"10 - 16","value":""},{"key":"PLT (Số lượng tiểu cầu)","unit_value":"G/L","reference_value":"150 - 450","value":""},{"key":"P-LCR (Tỷ lệ TC có KT lớn)","unit_value":"%","reference_value":"9 - 42","value":""},{"key":"MPV (Thể tích TB tiểu cầu)","unit_value":"fL","reference_value":"5 - 15","value":""},{"key":"PDW (Dải phần bổ KT tiểu cầu)","unit_value":"%","reference_value":"7 - 18","value":""},{"key":"WBC (Số lượng bạch cầu)","unit_value":"G/L","reference_value":"4 - 10","value":""},{"key":"LYMPH# (SL BC Lympho)","unit_value":"G/L","reference_value":"1 - 5","value":""},{"key":"MID# (SL BC mono, axit, bazo)","unit_value":"G/L","reference_value":"0.1 - 1.5","value":""},{"key":"NEUT# (SL BC Trung tính)","unit_value":"G/L","reference_value":"1.8 - 7.0","value":""},{"key":"LYMPH % (TL % BC Lympho)","unit_value":"%","reference_value":"25 - 50","value":""},{"key":"MID % (TL % BC mono, axit, bazo)","unit_value":"%","reference_value":"1 - 15","value":""},{"key":"NEUT % (TL % BC Trung tính)","unit_value":"%","reference_value":"45 - 70","value":""}]', 'driver_test' => 'Architect 3']
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

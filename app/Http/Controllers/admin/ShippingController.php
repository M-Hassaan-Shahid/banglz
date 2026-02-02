<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    public function postRates(Request $request)
    {
        $validated = $request->validate([
            'to_address.name' => 'required|string',
            'to_address.address1' => 'required|string',
            'to_address.city' => 'required|string',
            'to_address.postal_code' => 'nullable|string',
            'to_address.country_code' => 'required|string',
            'to_address.province_code' => 'nullable|string',
            'weight' => 'required|numeric',
            'weight_unit' => 'required|string',
            'length' => 'required|numeric|min:0.01',
            'width' => 'required|numeric|min:0.01',
            'height' => 'required|numeric|min:0.01',
            'size_unit' => 'nullable|string|in:cm,in',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.value' => 'nullable|numeric|min:0',
            'items.*.currency' => 'nullable|string|in:USD,CAD',
            'items.*.country_of_origin' => 'nullable|string',
            'items.*.hs_code' => 'nullable|string|size:10',
        ]);
        // dd($to)

        // ✅ Build payload for Stallion
        $payload = [
            'weight_unit' => 'lbs',
            'weight' => (float) $validated['weight'],
            'length' => (float) $validated['length'],
            'width' => (float) $validated['width'],
            'height' => (float) $validated['height'],
            'size_unit' => $validated['size_unit'] ?? 'cm',

            // ✅ use array for to_address (not curly braces)
            'to_address' => [
                'city' => $validated['to_address']['city'],
                'province_code' => $validated['to_address']['province_code'] ?? null,
                'postal_code' => $validated['to_address']['postal_code'] ?? null,
                'country_code' => $validated['to_address']['country_code'],
            ],
            'items' => $validated['items'],
        ];
        // dd($payload);
        $base = 'https://ship.stallionexpress.ca/api/v4';
        $token = env('STALLION_API_TOKEN');
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->retry(3, 5000)
                ->post($base . '/rates', $payload);

            $resp = $response;
            $data = $response->json();
            if (!$resp->successful()) {
                return response()->json([
                    'success' => false,
                    'errors' => $data['errors'] ?? ['Failed to call Stallion API'],
                ], $resp->status());
            }

            return response()->json([
                'success' => true,
                'rates' => $data['rates'] ?? [],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }

    public function BuyLabel(Request $request)
    {

        $validated = $request->validate([
            'to_address.name' => 'required|string',
            'to_address.address1' => 'nullable|string',
            'to_address.city' => 'required|string',
            'to_address.postal_code' => 'nullable|string',
            'to_address.country_code' => 'required|string',
            'to_address.province_code' => 'nullable|string',
            'to_address.phone' => 'nullable|string',
            'to_address.email' => 'nullable|email',
            'to_address.is_residential' => 'nullable|boolean',
            'to_address.lat' => 'nullable|numeric',
            'to_address.lng' => 'nullable|numeric',
            'weight' => 'required|numeric',
            'weight_unit' => 'required|string',
            'length' => 'required|numeric|min:0.01',
            'width' => 'required|numeric|min:0.01',
            'height' => 'required|numeric|min:0.01',
            'size_unit' => 'nullable|string|in:cm,in',
            'package_type' => 'required|string',
            'postage_type' => 'required|string',
            'package_contents' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.value' => 'required|numeric|min:0',
            'items.*.currency' => 'required|string|in:USD,CAD',

        ]);
        $validated['package_contents'] = $validated['package_contents'] ?? 'Merchandise';

        // ✅ Always use jewellery defaults
        foreach ($validated['items'] as &$item) {
            $item['country_of_origin'] = 'CA';
            $item['hs_code'] = '7117907500';
            $item['description'] = $item['description'] ?? 'Jewellery';
        }
$provinceCode = $validated['to_address']['province_code'] ?? null;
            //    dd($validated['to_address']);

if (strlen($provinceCode) > 2 && !empty($validated['to_address']['lat']) && !empty($validated['to_address']['lng'])) {
    try {

            $geoResponse = Http::withHeaders([
                'User-Agent' => 'MyLaravelApp/1.0 (tahir@example.com)',
            ])->get('https://nominatim.openstreetmap.org/reverse', [
                'lat' => $validated['to_address']['lat'],
                'lon' => $validated['to_address']['lng'],
                'format' => 'json',
            ]);

            if ($geoResponse->successful()) {
                $geoData = $geoResponse->json();
                $isoCode = $geoData['address']['ISO3166-2-lvl4'] ?? null;
                // dd($isoCode);
                // ✅ Extract last 2 letters if code is valid (e.g. "PK-SD" → "SD")
                if (!empty($isoCode) && strlen($isoCode) > 2) {
                    $parts = explode('-', $isoCode);
                    $provinceCode = strtoupper(end($parts)); // e.g. "SD"
                }
            }
        } catch (\Throwable $e) {
            // just skip if lookup fails
        }
    }
        // ✅ Build payload

        $payload = [
            'to_address' => [
                'name' => $validated['to_address']['name'],
                // 'address1' => $validated['to_address']['address1'],
                'city' => $validated['to_address']['city'],
                'province_code' => $provinceCode ?? null,
                'postal_code' => $validated['to_address']['postal_code'] ?? null,
                'country_code' => $validated['to_address']['country_code'],
                'phone' => $validated['to_address']['phone'] ?? '0000000000',
                'email' => $validated['to_address']['email'] ?? 'no-reply@banglez.ca',
                'is_residential' => true,
            ],
            'weight_unit' => $validated['weight_unit'],
            'weight' => (float) $validated['weight'],
            'length' => (float) $validated['length'],
            'width' => (float) $validated['width'],
            'height' => (float) $validated['height'],
            'size_unit' => $validated['size_unit'] ?? 'cm',
            'package_type' => $validated['package_type'],
            'package_contents' => $validated['package_contents'] ?? 'Jewellery',
            'items' => $validated['items'],
            'postage_type' => $validated['postage_type'],
        ];
        // dd($payload);
        // ✅ Stallion Mock URL
        $base = 'https://stallionexpress.redocly.app/_mock/stallionexpress-v4';
        $token = env('STALLION_API_TOKEN');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Idempotency-Key' => uniqid('label_', true),
            ])->retry(3, 5000)
                ->post($base . '/shipments', $payload);

            $data = $response->json();

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'errors' => $data['errors'] ?? ['Failed to create label'],
                ], $response->status());
            }
$order=Order::where('id','=',$request['order_id'])->first();
            $order->update([
                'status' => 'processing',
            ]);
            return response()->json([
                'success' => true,
                'shipment' => $data,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'errors' => [$e->getMessage()],
            ], 500);
        }
    }
}

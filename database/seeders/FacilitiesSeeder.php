<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilities = [
            ['code' => '0001', 'name' => '24 Hour Access', 'created_at' => now()],
            ['code' => '0002', 'name' => 'Advice & Support Service', 'created_at' => now()],
            ['code' => '0003', 'name' => 'Alarm or manned security', 'created_at' => now()],
            ['code' => '0004', 'name' => 'Broadband', 'created_at' => now()],
            ['code' => '0005', 'name' => 'Call Answering', 'created_at' => now()],
            ['code' => '0006', 'name' => 'CAT 5 Cabling', 'created_at' => now()],
            ['code' => '0007', 'name' => 'CCTV Security', 'created_at' => now()],
            ['code' => '0008', 'name' => 'Courier Service', 'created_at' => now()],
            ['code' => '0009', 'name' => 'Digital Telephone System', 'created_at' => now()],
            ['code' => '0010', 'name' => 'Lift/Elevator', 'created_at' => now()],
            ['code' => '0011', 'name' => 'Manned Reception', 'created_at' => now()],
            ['code' => '0012', 'name' => 'Office Cleaning', 'created_at' => now()],
            ['code' => '0013', 'name' => 'Internet Access', 'created_at' => now()],
            ['code' => '0014', 'name' => 'Kitchen Facility', 'created_at' => now()],
            ['code' => '0015', 'name' => 'Lounge Area', 'created_at' => now()],
            ['code' => '0016', 'name' => 'Office with fax machine', 'created_at' => now()],
            ['code' => '0017', 'name' => 'Personalized Telephone Answering', 'created_at' => now()],
            ['code' => '0018', 'name' => 'Photocopying and Faxing', 'created_at' => now()],
            ['code' => '0019', 'name' => 'Scanning Equipment', 'created_at' => now()],
            ['code' => '0020', 'name' => 'Secure LAN Connections', 'created_at' => now()],
            ['code' => '0021', 'name' => 'Storage Area', 'created_at' => now()],
            ['code' => '0022', 'name' => 'Video Conferencing', 'created_at' => now()],
            ['code' => '0023', 'name' => 'Visitor Car Parking', 'created_at' => now()],
            ['code' => '0024', 'name' => 'Air Conditioner', 'created_at' => now()],
            ['code' => '0025', 'name' => 'Alarmed office', 'created_at' => now()],
            ['code' => '0026', 'name' => 'Car Parking', 'created_at' => now()],
            ['code' => '0027', 'name' => 'Catering Facilities/Refreshments', 'created_at' => now()],
            ['code' => '0028', 'name' => 'Meeting Room/Conference', 'created_at' => now()],
            ['code' => '0029', 'name' => 'Office Furniture', 'created_at' => now()],
            ['code' => '0030', 'name' => 'Secretarial & Administrative Service', 'created_at' => now()],
            ['code' => '0031', 'name' => 'Equipped Kitchen', 'created_at' => now()],
            ['code' => '0032', 'name' => 'TV Cable/Satellite', 'created_at' => now()],
            ['code' => '0033', 'name' => 'Free WI-FI broadband internet', 'created_at' => now()],
            ['code' => '0034', 'name' => 'Secure key card only entrance', 'created_at' => now()],
            ['code' => '0035', 'name' => 'Night time security', 'created_at' => now()],
            ['code' => '0036', 'name' => 'Security System', 'created_at' => now()],
            ['code' => '0037', 'name' => 'Air-Conditioning throughout', 'created_at' => now()],
            ['code' => '0038', 'name' => 'Hot Water', 'created_at' => now()],
            ['code' => '0039', 'name' => 'Fridge', 'created_at' => now()],
            ['code' => '0040', 'name' => 'Kitchen including two ring electric stove', 'created_at' => now()],
            ['code' => '0041', 'name' => 'Microwave', 'created_at' => now()],
            ['code' => '0042', 'name' => 'Large TV with DVD player', 'created_at' => now()],
            ['code' => '0043', 'name' => 'Front and rear balconies', 'created_at' => now()],
            ['code' => '0044', 'name' => 'Private rear and/or front gardens', 'created_at' => now()],
            ['code' => '0045', 'name' => 'Fan', 'created_at' => now()],
            ['code' => '0046', 'name' => 'Kitchen', 'created_at' => now()],
            ['code' => '0047', 'name' => 'Living Room', 'created_at' => now()],
            ['code' => '0048', 'name' => 'Exterior Painting', 'created_at' => now()],
            ['code' => '0049', 'name' => 'Interior Painting', 'created_at' => now()],
            ['code' => '0050', 'name' => 'Residential', 'created_at' => now()],
            ['code' => '0051', 'name' => 'Toilet', 'created_at' => now()],
            ['code' => '0052', 'name' => 'Lubricant services office', 'created_at' => now()],
            ['code' => '0053', 'name' => 'Garden', 'created_at' => now()],
            ['code' => '0054', 'name' => 'Swimming Pool', 'created_at' => now()],
            ['code' => '0055', 'name' => 'Video Conferencing', 'created_at' => now()],
            ['code' => '0056', 'name' => 'Support & Training', 'created_at' => now()],
            ['code' => '0057', 'name' => 'Gym', 'created_at' => now()],
            ['code' => '0058', 'name' => 'Sauna', 'created_at' => now()],
            ['code' => '0059', 'name' => 'Water Supply', 'created_at' => now()],
            ['code' => '0060', 'name' => 'Electricity Supply', 'created_at' => now()],
            ['code' => '0061', 'name' => 'Title deed', 'created_at' => now()],
            ['code' => '0062', 'name' => 'Waste collection', 'created_at' => now()],
            ['code' => '0063', 'name' => 'Wall', 'created_at' => now()],
            ['code' => '0064', 'name' => 'Tree', 'created_at' => now()],
            ['code' => '0065', 'name' => 'City Views', 'created_at' => now()],
            ['code' => '0066', 'name' => 'On main road', 'created_at' => now()],
            ['code' => '0067', 'name' => 'Commercial area', 'created_at' => now()],
            ['code' => '0068', 'name' => 'Non-Flooding', 'created_at' => now()],
            ['code' => '0069', 'name' => 'Lift / Elevator', 'created_at' => now()],
            ['code' => '0070', 'name' => 'Alarm System', 'created_at' => now()],
            ['code' => '0071', 'name' => 'Fire Alarm', 'created_at' => now()],
            ['code' => '0072', 'name' => 'Fire sprinkler system', 'created_at' => now()],
            ['code' => '0073', 'name' => 'Video Security', 'created_at' => now()],
            ['code' => '0074', 'name' => 'Backup Electricity / Generator', 'created_at' => now()],
            ['code' => '0075', 'name' => 'Solvent Parts Cleaning', 'created_at' => now()],
            ['code' => '0076', 'name' => 'Brake Repair', 'created_at' => now()],
            ['code' => '0077', 'name' => 'Air Conditioner and Radiator Servicing', 'created_at' => now()],
            ['code' => '0078', 'name' => 'Battery charger and jumper', 'created_at' => now()],
            ['code' => '0079', 'name' => 'General Equipment', 'created_at' => now()],
            ['code' => '0080', 'name' => 'Coolant Flush', 'created_at' => now()],
            ['code' => '0081', 'name' => 'Vehicle Lift', 'created_at' => now()],
            ['code' => '0082', 'name' => 'Oil drain and oil caddy', 'created_at' => now()],
            ['code' => '0083', 'name' => 'Air Compressor', 'created_at' => now()],
            ['code' => '0084', 'name' => 'Jack, jack stands, and pole jacks', 'created_at' => now()],
            ['code' => '0085', 'name' => 'Engine hoist', 'created_at' => now()],
            ['code' => '0086', 'name' => 'Brake lathe', 'created_at' => now()],
            ['code' => '0087', 'name' => 'Strut compressor', 'created_at' => now()],
            ['code' => '0088', 'name' => 'Air conditioning machine', 'created_at' => now()],
            ['code' => '0089', 'name' => 'Press', 'created_at' => now()],
            ['code' => '0090', 'name' => 'Computers and Smartphones', 'created_at' => now()],
            ['code' => '0091', 'name' => 'Internet and Communications', 'created_at' => now()],
            ['code' => '0092', 'name' => 'Printer and Shredder', 'created_at' => now()],
            ['code' => '0093', 'name' => 'Security Systems', 'created_at' => now()],
            ['code' => '0094', 'name' => 'Reception desk', 'created_at' => now()],
            ['code' => '0095', 'name' => 'Reception chairs', 'created_at' => now()],
            ['code' => '0096', 'name' => 'Salon chairs', 'created_at' => now()],
            ['code' => '0097', 'name' => 'Hair styling stations', 'created_at' => now()],
            ['code' => '0098', 'name' => 'Backwash units (shampoo stations)', 'created_at' => now()],
            ['code' => '0099', 'name' => 'Carts and trolleys', 'created_at' => now()],
            ['code' => '0100', 'name' => 'Salon retail stands', 'created_at' => now()],
            ['code' => '0101', 'name' => 'Lighting', 'created_at' => now()],
            ['code' => '0102', 'name' => 'Magazine rack', 'created_at' => now()],
            ['code' => '0103', 'name' => 'Hood dryers', 'created_at' => now()],
            ['code' => '0104', 'name' => 'Heat lamps', 'created_at' => now()],
            ['code' => '0105', 'name' => 'Blow dryers', 'created_at' => now()],
            ['code' => '0106', 'name' => 'Hair straighteners', 'created_at' => now()],
            ['code' => '0107', 'name' => 'Hair curlers', 'created_at' => now()],
            ['code' => '0108', 'name' => 'Hair clippers', 'created_at' => now()],
            ['code' => '0109', 'name' => 'Washing machine and a dryer (for towels)', 'created_at' => now()],
            ['code' => '0110', 'name' => 'Bar stools', 'created_at' => now()],
            ['code' => '0111', 'name' => 'Table', 'created_at' => now()],
            ['code' => '0112', 'name' => 'Lounge', 'created_at' => now()],
            ['code' => '0113', 'name' => 'Sofa', 'created_at' => now()],
            ['code' => '0114', 'name' => 'Walk in cooler door', 'created_at' => now()],
            ['code' => '0115', 'name' => 'Glass Top Display Freezers', 'created_at' => now()],
            ['code' => '0116', 'name' => 'Vending Machines', 'created_at' => now()],
            ['code' => '0117', 'name' => 'Ice Merchandisers', 'created_at' => now()],
            ['code' => '0118', 'name' => 'shelve', 'created_at' => now()],
            ['code' => '0119', 'name' => 'Speakers ', 'created_at' => now()],
            ['code' => '0120', 'name' => 'Bottle Cooler', 'created_at' => now()],
            ['code' => '0121', 'name' => 'Freezer', 'created_at' => now()],
            ['code' => '0122', 'name' => 'Under-bar sink', 'created_at' => now()],
            ['code' => '0123', 'name' => 'Soda making equipment', 'created_at' => now()],
            ['code' => '0124', 'name' => 'Ice Machine', 'created_at' => now()],
            ['code' => '0125', 'name' => 'Glass racks and speed rail', 'created_at' => now()],
            ['code' => '0126', 'name' => 'DJ set', 'created_at' => now()],
            ['code' => '0127', 'name' => 'Bar Sign', 'created_at' => now()],
            ['code' => '0128', 'name' => 'Glassware in various sizes', 'created_at' => now()],
            ['code' => '0129', 'name' => 'Bar lighting', 'created_at' => now()],
            ['code' => '0130', 'name' => 'Outdoor furniture and umbrellas', 'created_at' => now()],
            ['code' => '0131', 'name' => 'Overhead menus', 'created_at' => now()],
            ['code' => '0132', 'name' => 'In-store menus and displays', 'created_at' => now()],
            ['code' => '0133', 'name' => 'Wall art, framed photos/posters, etc.', 'created_at' => now()],
            ['code' => '0134', 'name' => 'Audio systems', 'created_at' => now()],
            ['code' => '0135', 'name' => 'Poseur Tables.', 'created_at' => now()],
            ['code' => '0136', 'name' => 'Canteen Furniture.', 'created_at' => now()],
            ['code' => '0137', 'name' => 'Serving Trolling', 'created_at' => now()],
            ['code' => '0138', 'name' => 'Bar Counters', 'created_at' => now()],
            ['code' => '0139', 'name' => 'Desk', 'created_at' => now()],
            ['code' => '0140', 'name' => 'Mezzanines', 'created_at' => now()],
            ['code' => '0141', 'name' => 'Petrol pump machine', 'created_at' => now()],
            ['code' => '0142', 'name' => 'Mini Mart', 'created_at' => now()],
            ['code' => '0143', 'name' => 'Cafe Shop', 'created_at' => now()],
            ['code' => '0144', 'name' => 'Car Wash Machine', 'created_at' => now()],
        ];

        DB::table('facilities')->insert($facilities);
    }
}

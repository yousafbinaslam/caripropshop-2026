import React from 'react';
import { motion } from 'framer-motion';
import { FileText, Handshake, AlertCircle, DollarSign, Clock, Shield } from 'lucide-react';

const TermsConditions: React.FC = () => {
  return (
    <div className="min-h-screen bg-gray-50 py-20">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="bg-white rounded-2xl shadow-lg p-8"
        >
          <div className="text-center mb-12">
            <FileText className="w-16 h-16 text-amber-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Terms & Conditions</h1>
            <p className="text-gray-600">Effective date: {new Date().toLocaleDateString()}</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Handshake className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Service Agreement</h2>
              </div>
              <div className="bg-blue-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-3">Scope of Services</h3>
                <ul className="space-y-2 text-gray-700">
                  <li>• Interior design consultation and planning</li>
                  <li>• Space planning and layout design</li>
                  <li>• Material selection and specification</li>
                  <li>• Project management and coordination</li>
                  <li>• 3D visualization and rendering services</li>
                  <li>• Construction documentation and oversight</li>
                </ul>
              </div>
              <div className="bg-green-50 p-6 rounded-lg mt-4">
                <h3 className="font-semibold text-gray-900 mb-3">Client Responsibilities</h3>
                <ul className="space-y-2 text-gray-700">
                  <li>• Provide accurate project information and requirements</li>
                  <li>• Ensure site access for measurements and inspections</li>
                  <li>• Timely approval of design concepts and changes</li>
                  <li>• Payment according to agreed schedule</li>
                  <li>• Compliance with local building codes and regulations</li>
                </ul>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <DollarSign className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Payment Terms</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-purple-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Payment Schedule</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Initial consultation: 50% upfront</li>
                    <li>• Design development: 30% upon approval</li>
                    <li>• Implementation phase: 20% upon completion</li>
                    <li>• Additional services: As agreed separately</li>
                  </ul>
                </div>
                <div className="bg-orange-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Payment Methods</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Bank transfer (preferred)</li>
                    <li>• Credit/debit cards</li>
                    <li>• Digital payment platforms</li>
                    <li>• Installment plans (for large projects)</li>
                  </ul>
                </div>
              </div>
              <div className="bg-red-50 p-4 rounded-lg mt-4">
                <p className="text-red-800 text-sm">
                  <strong>Late Payment:</strong> A 2% monthly service charge applies to overdue amounts. 
                  Services may be suspended for payments more than 30 days overdue.
                </p>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Clock className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Project Timeline & Changes</h2>
              </div>
              <div className="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Timeline Management</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Project timelines are estimates based on scope</li>
                      <li>• Delays due to client changes may extend timeline</li>
                      <li>• Force majeure events may affect schedules</li>
                      <li>• Regular progress updates will be provided</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Change Requests</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• All changes must be requested in writing</li>
                      <li>• Additional fees may apply for scope changes</li>
                      <li>• Timeline adjustments will be communicated</li>
                      <li>• Client approval required before implementation</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Shield className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Intellectual Property & Warranties</h2>
              </div>
              <div className="space-y-4">
                <div className="bg-yellow-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Design Ownership</h3>
                  <p className="text-gray-700 text-sm mb-3">
                    All design concepts, drawings, and specifications remain the intellectual property of 
                    Cari Prop Shop until full payment is received. Upon completion of payment, client 
                    receives usage rights for the specific project only.
                  </p>
                  <ul className="space-y-1 text-gray-700 text-sm">
                    <li>• Designs may not be reproduced for other projects</li>
                    <li>• Commercial use requires separate licensing agreement</li>
                    <li>• Portfolio usage rights retained by Cari Prop Shop</li>
                  </ul>
                </div>
                <div className="bg-green-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Service Warranty</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Design services: 90-day revision period</li>
                    <li>• Project management: Performance guarantee</li>
                    <li>• Material specifications: Accuracy warranty</li>
                    <li>• Professional liability insurance coverage</li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <AlertCircle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Limitations & Liability</h2>
              </div>
              <div className="bg-red-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-3">Limitation of Liability</h3>
                <p className="text-gray-700 text-sm mb-4">
                  Cari Prop Shop's liability is limited to the total amount paid for services. 
                  We are not liable for:
                </p>
                <div className="grid md:grid-cols-2 gap-4">
                  <ul className="space-y-1 text-gray-700 text-sm">
                    <li>• Indirect or consequential damages</li>
                    <li>• Third-party contractor performance</li>
                    <li>• Material defects or availability</li>
                    <li>• Permit or regulatory approval delays</li>
                  </ul>
                  <ul className="space-y-1 text-gray-700 text-sm">
                    <li>• Client-requested design modifications</li>
                    <li>• Site conditions not disclosed</li>
                    <li>• Force majeure events</li>
                    <li>• Changes in building codes</li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <FileText className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Termination & Dispute Resolution</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-gray-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Termination Conditions</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Either party: 30 days written notice</li>
                    <li>• Immediate termination for breach</li>
                    <li>• Payment due for completed work</li>
                    <li>• Return of client materials</li>
                  </ul>
                </div>
                <div className="bg-gray-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Dispute Resolution</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Good faith negotiation first</li>
                    <li>• Mediation if negotiation fails</li>
                    <li>• Arbitration as final resort</li>
                    <li>• Indonesian law governs</li>
                  </ul>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Contact & Acceptance</h2>
              <div className="bg-amber-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  By engaging our services, you acknowledge that you have read, understood, and agree to these terms and conditions.
                </p>
                <div className="grid md:grid-cols-2 gap-4">
                  <div>
                    <p className="font-semibold text-gray-900">Legal Contact</p>
                    <p className="text-gray-700">Cari Prop Shop</p>
                    <p className="text-gray-700">Email: legal@caripropshop.com</p>
                    <p className="text-gray-700">Phone: Available upon request</p>
                  </div>
                  <div>
                    <p className="font-semibold text-gray-900">Business Registration</p>
                    <p className="text-gray-700">Surabaya East, Indonesia</p>
                    <p className="text-gray-700">Licensed Interior Design Firm</p>
                    <p className="text-gray-700">Professional Liability Insured</p>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default TermsConditions;
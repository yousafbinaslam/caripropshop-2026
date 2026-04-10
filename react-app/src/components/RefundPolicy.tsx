import React from 'react';
import { motion } from 'framer-motion';
import { RefreshCw, DollarSign, Clock, CheckCircle, XCircle, AlertCircle } from 'lucide-react';

const RefundPolicy: React.FC = () => {
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
            <RefreshCw className="w-16 h-16 text-amber-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Refund Policy</h1>
            <p className="text-gray-600">Fair and transparent refund terms for our design services</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <DollarSign className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Refund Eligibility</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-green-50 p-6 rounded-lg border border-green-200">
                  <div className="flex items-center mb-3">
                    <CheckCircle className="w-6 h-6 text-green-600 mr-2" />
                    <h3 className="font-semibold text-gray-900">Eligible for Refund</h3>
                  </div>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Service cancellation within 48 hours of agreement</li>
                    <li>• Failure to deliver agreed services</li>
                    <li>• Material breach of contract by Cari Prop Shop</li>
                    <li>• Unused consultation credits</li>
                    <li>• Force majeure preventing service delivery</li>
                  </ul>
                </div>
                <div className="bg-red-50 p-6 rounded-lg border border-red-200">
                  <div className="flex items-center mb-3">
                    <XCircle className="w-6 h-6 text-red-600 mr-2" />
                    <h3 className="font-semibold text-gray-900">Not Eligible for Refund</h3>
                  </div>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Completed design work and deliverables</li>
                    <li>• Client-initiated scope changes</li>
                    <li>• Cancellation after work has commenced</li>
                    <li>• Third-party contractor issues</li>
                    <li>• Client dissatisfaction with approved designs</li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Clock className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Refund Timeline & Process</h2>
              </div>
              <div className="space-y-4">
                {[
                  {
                    step: 'Step 1: Request Submission',
                    timeframe: 'Within 30 days',
                    description: 'Submit written refund request with supporting documentation',
                    color: 'blue'
                  },
                  {
                    step: 'Step 2: Review Process',
                    timeframe: '5-7 business days',
                    description: 'Internal review of refund eligibility and documentation',
                    color: 'purple'
                  },
                  {
                    step: 'Step 3: Decision Notification',
                    timeframe: '2-3 business days',
                    description: 'Written notification of refund decision and amount',
                    color: 'green'
                  },
                  {
                    step: 'Step 4: Payment Processing',
                    timeframe: '7-14 business days',
                    description: 'Refund processed to original payment method',
                    color: 'orange'
                  }
                ].map((step, index) => (
                  <div key={index} className={`bg-${step.color}-50 p-6 rounded-lg border border-${step.color}-200`}>
                    <div className="flex justify-between items-start mb-2">
                      <h3 className="font-semibold text-gray-900">{step.step}</h3>
                      <span className={`px-3 py-1 bg-${step.color}-100 text-${step.color}-800 text-sm rounded-full`}>
                        {step.timeframe}
                      </span>
                    </div>
                    <p className="text-gray-700 text-sm">{step.description}</p>
                  </div>
                ))}
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <AlertCircle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Partial Refunds & Service Credits</h2>
              </div>
              <div className="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Partial Refund Scenarios</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Project cancellation mid-phase</li>
                      <li>• Reduced scope of work</li>
                      <li>• Unused consultation hours</li>
                      <li>• Service delivery delays</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Service Credit Options</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Future project discounts</li>
                      <li>• Additional consultation hours</li>
                      <li>• Complimentary design updates</li>
                      <li>• Extended warranty periods</li>
                    </ul>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-yellow-100 rounded-lg">
                  <p className="text-yellow-800 text-sm">
                    <strong>Note:</strong> Partial refunds are calculated based on completed work value and 
                    project phase at time of cancellation.
                  </p>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <RefreshCw className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Refund Calculation Method</h2>
              </div>
              <div className="bg-blue-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Phase-Based Refund Structure</h3>
                <div className="space-y-3">
                  {[
                    { phase: 'Initial Consultation', refund: '100%', condition: 'If cancelled within 48 hours' },
                    { phase: 'Design Development', refund: '75%', condition: 'Before concept approval' },
                    { phase: 'Documentation Phase', refund: '50%', condition: 'Before final drawings' },
                    { phase: 'Implementation Phase', refund: '25%', condition: 'Before construction starts' },
                    { phase: 'Project Completion', refund: '0%', condition: 'After final delivery' }
                  ].map((item, index) => (
                    <div key={index} className="flex justify-between items-center p-3 bg-white rounded border">
                      <div>
                        <span className="font-medium text-gray-900">{item.phase}</span>
                        <p className="text-gray-600 text-sm">{item.condition}</p>
                      </div>
                      <span className="text-lg font-bold text-blue-600">{item.refund}</span>
                    </div>
                  ))}
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Special Circumstances</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-purple-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Emergency Situations</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Natural disasters affecting project site</li>
                    <li>• Sudden financial hardship (documented)</li>
                    <li>• Medical emergencies requiring relocation</li>
                    <li>• Legal issues preventing project completion</li>
                  </ul>
                  <p className="text-purple-800 text-xs mt-3">
                    Case-by-case evaluation with documentation required
                  </p>
                </div>
                <div className="bg-indigo-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Goodwill Gestures</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Long-term client relationships</li>
                    <li>• Referral program participants</li>
                    <li>• Repeat customers</li>
                    <li>• Community partnerships</li>
                  </ul>
                  <p className="text-indigo-800 text-xs mt-3">
                    Additional considerations for valued clients
                  </p>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">How to Request a Refund</h2>
              <div className="bg-amber-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Required Information</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Project reference number</li>
                      <li>• Original payment receipt</li>
                      <li>• Reason for refund request</li>
                      <li>• Supporting documentation</li>
                      <li>• Preferred refund method</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Contact Information</h3>
                    <div className="space-y-2 text-gray-700 text-sm">
                      <p><strong>Email:</strong> refunds@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                      <p><strong>Address:</strong> Surabaya East, Indonesia</p>
                      <p><strong>Business Hours:</strong> Mon-Fri 9AM-6PM</p>
                    </div>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-amber-100 rounded-lg">
                  <p className="text-amber-800 text-sm">
                    <strong>Important:</strong> All refund requests must be submitted in writing with 
                    supporting documentation. Verbal requests will not be processed.
                  </p>
                </div>
              </div>
            </section>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default RefundPolicy;
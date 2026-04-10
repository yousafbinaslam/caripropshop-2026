import React from 'react';
import { motion } from 'framer-motion';
import { FileCheck, Users, Calendar, Clipboard, CheckCircle, AlertTriangle } from 'lucide-react';

const ServiceAgreement: React.FC = () => {
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
            <FileCheck className="w-16 h-16 text-amber-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Service Agreement</h1>
            <p className="text-gray-600">Professional Interior Design Services Contract</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Users className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Parties & Project Scope</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-blue-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Service Provider</h3>
                  <div className="space-y-2 text-gray-700 text-sm">
                    <p><strong>Company:</strong> Cari Prop Shop</p>
                    <p><strong>Principal Designer:</strong> Licensed Professional</p>
                    <p><strong>License:</strong> Certified Interior Designer</p>
                    <p><strong>Location:</strong> Surabaya East, Indonesia</p>
                    <p><strong>Contact:</strong> Available upon request</p>
                  </div>
                </div>
                <div className="bg-green-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Service Categories</h3>
                  <ul className="space-y-1 text-gray-700 text-sm">
                    <li>• Residential Interior Design</li>
                    <li>• Commercial Space Planning</li>
                    <li>• Hospitality Design Services</li>
                    <li>• Design Consultation</li>
                    <li>• Project Management</li>
                    <li>• 3D Visualization Services</li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Calendar className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Project Phases & Deliverables</h2>
              </div>
              <div className="space-y-4">
                {[
                  {
                    phase: 'Phase 1: Discovery & Consultation',
                    duration: '1-2 weeks',
                    deliverables: ['Site survey and measurements', 'Client needs assessment', 'Budget analysis', 'Initial concept presentation'],
                    color: 'blue'
                  },
                  {
                    phase: 'Phase 2: Design Development',
                    duration: '2-4 weeks',
                    deliverables: ['Detailed floor plans', 'Material and finish selections', '3D renderings', 'Lighting design'],
                    color: 'purple'
                  },
                  {
                    phase: 'Phase 3: Documentation',
                    duration: '1-2 weeks',
                    deliverables: ['Construction drawings', 'Specifications document', 'Vendor coordination', 'Permit assistance'],
                    color: 'green'
                  },
                  {
                    phase: 'Phase 4: Implementation',
                    duration: '4-12 weeks',
                    deliverables: ['Project management', 'Quality control', 'Progress monitoring', 'Final walkthrough'],
                    color: 'orange'
                  }
                ].map((phase, index) => (
                  <div key={index} className={`bg-${phase.color}-50 p-6 rounded-lg border border-${phase.color}-200`}>
                    <div className="flex justify-between items-start mb-3">
                      <h3 className="font-semibold text-gray-900">{phase.phase}</h3>
                      <span className={`px-3 py-1 bg-${phase.color}-100 text-${phase.color}-800 text-sm rounded-full`}>
                        {phase.duration}
                      </span>
                    </div>
                    <div className="grid md:grid-cols-2 gap-4">
                      {phase.deliverables.map((deliverable, i) => (
                        <div key={i} className="flex items-center">
                          <CheckCircle className={`w-4 h-4 text-${phase.color}-600 mr-2`} />
                          <span className="text-gray-700 text-sm">{deliverable}</span>
                        </div>
                      ))}
                    </div>
                  </div>
                ))}
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Clipboard className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Professional Standards & Ethics</h2>
              </div>
              <div className="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Professional Conduct</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Adherence to industry best practices</li>
                      <li>• Compliance with local building codes</li>
                      <li>• Sustainable design principles</li>
                      <li>• Client confidentiality protection</li>
                      <li>• Transparent communication</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Quality Assurance</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Regular design review meetings</li>
                      <li>• Material quality verification</li>
                      <li>• Contractor performance monitoring</li>
                      <li>• Client satisfaction surveys</li>
                      <li>• Post-completion support</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <AlertTriangle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Risk Management & Insurance</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-red-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Insurance Coverage</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Professional liability insurance</li>
                    <li>• General liability coverage</li>
                    <li>• Errors and omissions protection</li>
                    <li>• Property damage coverage</li>
                  </ul>
                  <p className="text-red-800 text-xs mt-3">
                    Coverage limits and certificates available upon request
                  </p>
                </div>
                <div className="bg-yellow-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Risk Mitigation</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Detailed site assessments</li>
                    <li>• Structural engineer consultations</li>
                    <li>• Permit and code compliance</li>
                    <li>• Regular safety inspections</li>
                  </ul>
                  <p className="text-yellow-800 text-xs mt-3">
                    Client responsible for site safety during construction
                  </p>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Performance Guarantees</h2>
              </div>
              <div className="bg-green-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-3 gap-4">
                  <div className="text-center">
                    <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                      <span className="text-2xl font-bold text-green-600">90</span>
                    </div>
                    <h3 className="font-semibold text-gray-900 mb-2">Day Warranty</h3>
                    <p className="text-gray-700 text-sm">Design revisions and adjustments</p>
                  </div>
                  <div className="text-center">
                    <div className="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                      <span className="text-2xl font-bold text-blue-600">24</span>
                    </div>
                    <h3 className="font-semibold text-gray-900 mb-2">Hour Response</h3>
                    <p className="text-gray-700 text-sm">Client communication guarantee</p>
                  </div>
                  <div className="text-center">
                    <div className="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                      <span className="text-2xl font-bold text-purple-600">100</span>
                    </div>
                    <h3 className="font-semibold text-gray-900 mb-2">% Satisfaction</h3>
                    <p className="text-gray-700 text-sm">Client satisfaction commitment</p>
                  </div>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Agreement Execution</h2>
              <div className="bg-amber-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  This service agreement becomes effective upon signature by both parties and receipt of initial payment.
                </p>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Required Documents</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Signed service agreement</li>
                      <li>• Project brief and requirements</li>
                      <li>• Site access permissions</li>
                      <li>• Initial payment confirmation</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Next Steps</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Schedule initial consultation</li>
                      <li>• Site visit and measurements</li>
                      <li>• Project timeline confirmation</li>
                      <li>• Team introduction meeting</li>
                    </ul>
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

export default ServiceAgreement;
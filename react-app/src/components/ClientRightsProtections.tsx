import React from 'react';
import { motion } from 'framer-motion';
import { Shield, Users, CheckCircle, AlertTriangle, FileText, Phone, Clock, Heart } from 'lucide-react';

const ClientRightsProtections: React.FC = () => {
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
            <Shield className="w-16 h-16 text-blue-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Client Rights & Protections</h1>
            <p className="text-gray-600">Comprehensive client protection and rights framework</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Users className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Fundamental Client Rights</h2>
              </div>
              <div className="bg-blue-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Your Rights as Our Client</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Service Rights</h4>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                        Professional and competent service delivery
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                        Timely completion according to agreed schedule
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                        Quality work meeting industry standards
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                        Transparent pricing and billing practices
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                        Regular project updates and communication
                      </li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Information Rights</h4>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                        Clear explanation of design concepts
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                        Detailed cost breakdowns and estimates
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                        Access to project documentation
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                        Material and product specifications
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                        Timeline and milestone information
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Shield className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Privacy & Confidentiality Protection</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-green-50 p-6 rounded-lg border border-green-200">
                  <h3 className="font-semibold text-gray-900 mb-3">Personal Information Protection</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Secure storage of personal data</li>
                    <li>• Limited access on need-to-know basis</li>
                    <li>• No sharing without explicit consent</li>
                    <li>• Right to data correction and deletion</li>
                    <li>• Transparent data usage policies</li>
                    <li>• GDPR and local privacy law compliance</li>
                  </ul>
                </div>
                <div className="bg-purple-50 p-6 rounded-lg border border-purple-200">
                  <h3 className="font-semibold text-gray-900 mb-3">Project Confidentiality</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Non-disclosure of project details</li>
                    <li>• Secure handling of property information</li>
                    <li>• Confidential client communications</li>
                    <li>• Protected financial information</li>
                    <li>• Restricted access to design files</li>
                    <li>• Professional discretion maintained</li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <FileText className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Contract & Agreement Protections</h2>
              </div>
              <div className="bg-gradient-to-r from-orange-50 to-red-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Contract Safeguards</h3>
                <div className="grid md:grid-cols-3 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Clear Terms</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Plain language contracts</li>
                      <li>• Detailed scope of work</li>
                      <li>• Specific deliverables listed</li>
                      <li>• Clear payment schedules</li>
                      <li>• Defined timelines</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Fair Terms</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Reasonable cancellation policies</li>
                      <li>• Balanced risk allocation</li>
                      <li>• Fair change order procedures</li>
                      <li>• Equitable dispute resolution</li>
                      <li>• Transparent fee structures</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Protection Clauses</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Performance guarantees</li>
                      <li>• Quality assurance provisions</li>
                      <li>• Liability limitations</li>
                      <li>• Insurance requirements</li>
                      <li>• Warranty protections</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Clock className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Service Quality Guarantees</h2>
              </div>
              <div className="space-y-4">
                <div className="bg-indigo-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Performance Guarantees</h3>
                  <div className="grid md:grid-cols-2 gap-6">
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Design Quality</h4>
                      <ul className="space-y-1 text-gray-700 text-sm">
                        <li>• Professional design standards compliance</li>
                        <li>• Building code adherence guarantee</li>
                        <li>• Material specification accuracy</li>
                        <li>• Technical drawing precision</li>
                        <li>• Design revision rights (90 days)</li>
                      </ul>
                    </div>
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Service Delivery</h4>
                      <ul className="space-y-1 text-gray-700 text-sm">
                        <li>• On-time project completion</li>
                        <li>• Budget adherence commitment</li>
                        <li>• Regular communication schedule</li>
                        <li>• Professional conduct standards</li>
                        <li>• Client satisfaction guarantee</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div className="bg-yellow-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Warranty & Support</h3>
                  <div className="grid md:grid-cols-3 gap-4">
                    <div className="bg-white p-4 rounded border text-center">
                      <Clock className="w-8 h-8 text-yellow-600 mx-auto mb-2" />
                      <h4 className="font-semibold text-gray-900 mb-2">90-Day Warranty</h4>
                      <p className="text-gray-700 text-sm">Design revisions and corrections</p>
                    </div>
                    <div className="bg-white p-4 rounded border text-center">
                      <Phone className="w-8 h-8 text-green-600 mx-auto mb-2" />
                      <h4 className="font-semibold text-gray-900 mb-2">24-Hour Response</h4>
                      <p className="text-gray-700 text-sm">Client inquiry response time</p>
                    </div>
                    <div className="bg-white p-4 rounded border text-center">
                      <Heart className="w-8 h-8 text-red-600 mx-auto mb-2" />
                      <h4 className="font-semibold text-gray-900 mb-2">Satisfaction Promise</h4>
                      <p className="text-gray-700 text-sm">100% satisfaction commitment</p>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <AlertTriangle className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Complaint & Grievance Procedures</h2>
              </div>
              <div className="bg-red-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">How to File a Complaint</h3>
                <div className="space-y-4">
                  {[
                    {
                      step: 'Initial Contact',
                      timeframe: 'Immediate',
                      description: 'Contact project manager or client services',
                      actions: ['Document the issue', 'Gather relevant information', 'Contact designated representative'],
                      color: 'red'
                    },
                    {
                      step: 'Formal Review',
                      timeframe: '48 hours',
                      description: 'Management review and investigation',
                      actions: ['Issue acknowledgment', 'Investigation initiation', 'Stakeholder interviews'],
                      color: 'orange'
                    },
                    {
                      step: 'Resolution & Response',
                      timeframe: '5-7 days',
                      description: 'Solution implementation and follow-up',
                      actions: ['Resolution proposal', 'Client approval', 'Implementation plan'],
                      color: 'green'
                    }
                  ].map((step, index) => (
                    <div key={index} className={`bg-${step.color}-100 p-4 rounded-lg border border-${step.color}-200`}>
                      <div className="flex justify-between items-start mb-2">
                        <h4 className="font-medium text-gray-900">{step.step}</h4>
                        <span className={`text-xs text-${step.color}-700 bg-${step.color}-200 px-2 py-1 rounded`}>
                          {step.timeframe}
                        </span>
                      </div>
                      <p className="text-gray-700 text-sm mb-2">{step.description}</p>
                      <div className="flex flex-wrap gap-2">
                        {step.actions.map((action, i) => (
                          <span key={i} className="text-xs text-gray-600 bg-white px-2 py-1 rounded">
                            {action}
                          </span>
                        ))}
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Financial Protection & Refund Rights</h2>
              </div>
              <div className="bg-green-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Payment Protection</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Secure payment processing
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Milestone-based payment schedule
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        No upfront payment exceeding 50%
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Detailed invoicing and receipts
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Professional liability insurance
                      </li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Refund Entitlements</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        48-hour cancellation right
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Partial refunds for incomplete work
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Full refund for non-delivery
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Unused consultation credits
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Force majeure protections
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Users className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Accessibility & Accommodation Rights</h2>
              </div>
              <div className="bg-purple-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Equal Access Commitment</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Service Accessibility</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Wheelchair accessible office facilities</li>
                      <li>• Multiple communication options</li>
                      <li>• Flexible meeting arrangements</li>
                      <li>• Document format accommodations</li>
                      <li>• Language interpretation services</li>
                      <li>• Assistive technology support</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Design Accommodations</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Universal design principles</li>
                      <li>• Accessibility compliance expertise</li>
                      <li>• Adaptive equipment integration</li>
                      <li>• Sensory consideration design</li>
                      <li>• Mobility enhancement features</li>
                      <li>• Inclusive design consultation</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Client Rights Advocacy</h2>
              <div className="bg-blue-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  For questions about your rights, to file a complaint, or to request assistance with any client protection matter.
                </p>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Client Advocate</h3>
                    <div className="space-y-1 text-gray-700 text-sm">
                      <p><strong>Name:</strong> Cari Prop Shop</p>
                      <p><strong>Email:</strong> clientrights@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                      <p><strong>Response Time:</strong> 24 hours maximum</p>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Available Support</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Rights information and education</li>
                      <li>• Complaint filing assistance</li>
                      <li>• Mediation and resolution support</li>
                      <li>• Accessibility accommodation requests</li>
                    </ul>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-blue-100 rounded-lg">
                  <p className="text-blue-800 text-sm">
                    <strong>External Resources:</strong> You also have the right to contact relevant consumer protection 
                    agencies, professional licensing boards, or legal counsel if you believe your rights have been violated.
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

export default ClientRightsProtections;
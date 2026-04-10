import React from 'react';
import { motion } from 'framer-motion';
import { Scale, Users, MessageCircle, FileText, Clock, CheckCircle, AlertTriangle, Phone } from 'lucide-react';

const DisputeResolution: React.FC = () => {
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
            <Scale className="w-16 h-16 text-purple-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Dispute Resolution</h1>
            <p className="text-gray-600">Fair and efficient conflict resolution procedures</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <MessageCircle className="w-6 h-6 text-purple-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Dispute Resolution Framework</h2>
              </div>
              <div className="bg-purple-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Our Commitment to Fair Resolution</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Core Principles</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Good faith negotiation and communication</li>
                      <li>• Timely and efficient resolution processes</li>
                      <li>• Fair and impartial treatment of all parties</li>
                      <li>• Confidential and professional handling</li>
                      <li>• Cost-effective resolution methods</li>
                      <li>• Preservation of business relationships</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Resolution Goals</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Mutual satisfaction and understanding</li>
                      <li>• Practical and implementable solutions</li>
                      <li>• Minimal disruption to project timelines</li>
                      <li>• Learning and process improvement</li>
                      <li>• Relationship repair and strengthening</li>
                      <li>• Prevention of future conflicts</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Clock className="w-6 h-6 text-purple-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Step-by-Step Resolution Process</h2>
              </div>
              <div className="space-y-4">
                {[
                  {
                    step: 'Step 1: Direct Communication',
                    timeframe: '1-3 days',
                    description: 'Initial discussion between client and project team',
                    process: [
                      'Client raises concern with project manager',
                      'Issue documentation and fact gathering',
                      'Direct dialogue and clarification',
                      'Immediate resolution attempt'
                    ],
                    success_rate: '75%',
                    color: 'green'
                  },
                  {
                    step: 'Step 2: Management Mediation',
                    timeframe: '5-7 days',
                    description: 'Senior management involvement and mediation',
                    process: [
                      'Escalation to senior management',
                      'Comprehensive issue review',
                      'Stakeholder meetings and discussions',
                      'Mediated resolution proposal'
                    ],
                    success_rate: '20%',
                    color: 'blue'
                  },
                  {
                    step: 'Step 3: External Mediation',
                    timeframe: '2-4 weeks',
                    description: 'Professional third-party mediation services',
                    process: [
                      'Selection of qualified mediator',
                      'Formal mediation proceedings',
                      'Structured negotiation sessions',
                      'Binding mediation agreement'
                    ],
                    success_rate: '4%',
                    color: 'orange'
                  },
                  {
                    step: 'Step 4: Arbitration',
                    timeframe: '1-3 months',
                    description: 'Binding arbitration as final resolution',
                    process: [
                      'Arbitrator selection and appointment',
                      'Evidence presentation and hearings',
                      'Legal representation if desired',
                      'Final binding arbitration award'
                    ],
                    success_rate: '1%',
                    color: 'red'
                  }
                ].map((step, index) => (
                  <div key={index} className={`bg-${step.color}-50 p-6 rounded-lg border border-${step.color}-200`}>
                    <div className="flex justify-between items-start mb-3">
                      <h3 className="font-semibold text-gray-900">{step.step}</h3>
                      <div className="flex gap-2">
                        <span className={`px-3 py-1 bg-${step.color}-100 text-${step.color}-800 text-sm rounded-full`}>
                          {step.timeframe}
                        </span>
                        <span className={`px-3 py-1 bg-${step.color}-100 text-${step.color}-800 text-sm rounded-full`}>
                          {step.success_rate} of cases
                        </span>
                      </div>
                    </div>
                    <p className="text-gray-700 text-sm mb-4">{step.description}</p>
                    <div className="grid md:grid-cols-2 gap-4">
                      {step.process.map((item, i) => (
                        <div key={i} className="flex items-center">
                          <CheckCircle className={`w-4 h-4 text-${step.color}-600 mr-2`} />
                          <span className="text-gray-700 text-sm">{item}</span>
                        </div>
                      ))}
                    </div>
                  </div>
                ))}
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <FileText className="w-6 h-6 text-purple-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Common Dispute Categories</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-blue-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Design & Quality Issues</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li className="flex items-center">
                      <AlertTriangle className="w-4 h-4 text-blue-600 mr-2" />
                      Design not meeting client expectations
                    </li>
                    <li className="flex items-center">
                      <AlertTriangle className="w-4 h-4 text-blue-600 mr-2" />
                      Quality of workmanship concerns
                    </li>
                    <li className="flex items-center">
                      <AlertTriangle className="w-4 h-4 text-blue-600 mr-2" />
                      Material specification disputes
                    </li>
                    <li className="flex items-center">
                      <AlertTriangle className="w-4 h-4 text-blue-600 mr-2" />
                      Code compliance issues
                    </li>
                    <li className="flex items-center">
                      <AlertTriangle className="w-4 h-4 text-blue-600 mr-2" />
                      Functionality and usability problems
                    </li>
                  </ul>
                </div>
                <div className="bg-green-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Project Management Disputes</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li className="flex items-center">
                      <AlertTriangle className="w-4 h-4 text-green-600 mr-2" />
                      Timeline delays and scheduling conflicts
                    </li>
                    <li className="flex items-center">
                      <AlertTriangle className="w-4 h-4 text-green-600 mr-2" />
                      Budget overruns and cost disputes
                    </li>
                    <li className="flex items-center">
                      <AlertTriangle className="w-4 h-4 text-green-600 mr-2" />
                      Communication and coordination issues
                    </li>
                    <li className="flex items-center">
                      <AlertTriangle className="w-4 h-4 text-green-600 mr-2" />
                      Change order disagreements
                    </li>
                    <li className="flex items-center">
                      <AlertTriangle className="w-4 h-4 text-green-600 mr-2" />
                      Contractor performance problems
                    </li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Users className="w-6 h-6 text-purple-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Mediation & Arbitration Services</h2>
              </div>
              <div className="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Professional Dispute Resolution Partners</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Mediation Services</h4>
                    <div className="space-y-3">
                      <div className="bg-white p-3 rounded border">
                        <h5 className="font-medium text-gray-900">Indonesian Mediation Center</h5>
                        <p className="text-gray-600 text-sm">Professional commercial mediation</p>
                        <p className="text-gray-500 text-xs">Average resolution: 2-3 weeks</p>
                      </div>
                      <div className="bg-white p-3 rounded border">
                        <h5 className="font-medium text-gray-900">Construction Industry Mediation</h5>
                        <p className="text-gray-600 text-sm">Specialized construction disputes</p>
                        <p className="text-gray-500 text-xs">Industry-specific expertise</p>
                      </div>
                    </div>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Arbitration Services</h4>
                    <div className="space-y-3">
                      <div className="bg-white p-3 rounded border">
                        <h5 className="font-medium text-gray-900">BANI (Indonesian Arbitration Board)</h5>
                        <p className="text-gray-600 text-sm">National arbitration authority</p>
                        <p className="text-gray-500 text-xs">Binding arbitration awards</p>
                      </div>
                      <div className="bg-white p-3 rounded border">
                        <h5 className="font-medium text-gray-900">Singapore International Arbitration</h5>
                        <p className="text-gray-600 text-sm">International commercial arbitration</p>
                        <p className="text-gray-500 text-xs">Cross-border dispute resolution</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-purple-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Prevention & Early Intervention</h2>
              </div>
              <div className="bg-yellow-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Proactive Dispute Prevention</h3>
                <div className="grid md:grid-cols-3 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Clear Communication</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Regular project updates</li>
                      <li>• Detailed documentation</li>
                      <li>• Expectation management</li>
                      <li>• Open feedback channels</li>
                      <li>• Milestone reviews</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Quality Control</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Design review processes</li>
                      <li>• Quality checkpoints</li>
                      <li>• Client approval stages</li>
                      <li>• Performance monitoring</li>
                      <li>• Continuous improvement</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Relationship Management</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Trust building activities</li>
                      <li>• Conflict early warning systems</li>
                      <li>• Regular satisfaction surveys</li>
                      <li>• Team building exercises</li>
                      <li>• Partnership approach</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Scale className="w-6 h-6 text-purple-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Legal Framework & Jurisdiction</h2>
              </div>
              <div className="bg-red-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Governing Law & Jurisdiction</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Applicable Law</h4>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Indonesian Civil Code and Commercial Law</li>
                      <li>• Consumer Protection Law No. 8/1999</li>
                      <li>• Construction Services Law No. 2/2017</li>
                      <li>• Professional Services Regulations</li>
                      <li>• International arbitration conventions</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Jurisdiction & Venue</h4>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Primary jurisdiction: Surabaya, Indonesia</li>
                      <li>• Alternative dispute resolution preferred</li>
                      <li>• Indonesian courts as final resort</li>
                      <li>• International arbitration for cross-border</li>
                      <li>• Enforcement through local courts</li>
                    </ul>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-red-100 rounded-lg">
                  <p className="text-red-800 text-sm">
                    <strong>Important:</strong> All dispute resolution procedures are conducted in accordance with 
                    Indonesian law and international best practices. Legal representation is permitted at all stages.
                  </p>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Clock className="w-6 h-6 text-purple-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Costs & Fees</h2>
              </div>
              <div className="bg-green-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Dispute Resolution Costs</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Internal Resolution (Steps 1-2)</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• No additional fees for clients</li>
                      <li>• Included in service agreement</li>
                      <li>• Management time provided at no cost</li>
                      <li>• Documentation and communication included</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">External Resolution (Steps 3-4)</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Mediation costs shared equally</li>
                      <li>• Arbitration fees per BANI schedule</li>
                      <li>• Each party bears own legal costs</li>
                      <li>• Administrative fees as applicable</li>
                    </ul>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-green-100 rounded-lg">
                  <p className="text-green-800 text-sm">
                    <strong>Cost Mitigation:</strong> We strongly encourage early resolution to minimize costs 
                    and maintain positive working relationships. Most disputes are resolved at no additional cost.
                  </p>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Dispute Resolution Contact</h2>
              <div className="bg-purple-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  For dispute resolution assistance, mediation requests, or conflict prevention consultation.
                </p>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Dispute Resolution Coordinator</h3>
                    <div className="space-y-1 text-gray-700 text-sm">
                      <p><strong>Name:</strong> Cari Prop Shop</p>
                      <p><strong>Email:</strong> disputes@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                      <p><strong>Emergency Line:</strong> 24/7 availability</p>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Available Services</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Conflict assessment and triage</li>
                      <li>• Mediation coordination</li>
                      <li>• Arbitration process management</li>
                      <li>• Prevention strategy consultation</li>
                    </ul>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-purple-100 rounded-lg">
                  <p className="text-purple-800 text-sm">
                    <strong>Confidentiality Guarantee:</strong> All dispute resolution communications are treated 
                    as confidential and privileged. Information shared will not be used against any party.
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

export default DisputeResolution;
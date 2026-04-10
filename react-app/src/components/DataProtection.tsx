import React from 'react';
import { motion } from 'framer-motion';
import { Shield, Lock, Eye, Database, UserCheck, AlertTriangle, FileText, Globe } from 'lucide-react';

const DataProtection: React.FC = () => {
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
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Data Protection & GDPR</h1>
            <p className="text-gray-600">Comprehensive data privacy and protection compliance</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Database className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibent text-gray-900">Data Collection & Processing</h2>
              </div>
              <div className="bg-blue-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Types of Data We Collect</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Personal Information</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Full name and contact details</li>
                      <li>• Email addresses and phone numbers</li>
                      <li>• Postal addresses and locations</li>
                      <li>• Professional titles and company information</li>
                      <li>• Payment and billing information</li>
                      <li>• Communication preferences</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Project-Related Data</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Property details and measurements</li>
                      <li>• Design preferences and requirements</li>
                      <li>• Budget and timeline information</li>
                      <li>• Project photos and documentation</li>
                      <li>• Meeting notes and communications</li>
                      <li>• Feedback and satisfaction surveys</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Lock className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">GDPR Compliance Framework</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-green-50 p-6 rounded-lg border border-green-200">
                  <h3 className="font-semibold text-gray-900 mb-3">Legal Basis for Processing</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li className="flex items-center">
                      <UserCheck className="w-4 h-4 text-green-600 mr-2" />
                      Consent for marketing communications
                    </li>
                    <li className="flex items-center">
                      <UserCheck className="w-4 h-4 text-green-600 mr-2" />
                      Contract performance for service delivery
                    </li>
                    <li className="flex items-center">
                      <UserCheck className="w-4 h-4 text-green-600 mr-2" />
                      Legitimate interest for business operations
                    </li>
                    <li className="flex items-center">
                      <UserCheck className="w-4 h-4 text-green-600 mr-2" />
                      Legal obligation for financial records
                    </li>
                  </ul>
                </div>
                <div className="bg-purple-50 p-6 rounded-lg border border-purple-200">
                  <h3 className="font-semibold text-gray-900 mb-3">Data Subject Rights</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li className="flex items-center">
                      <Eye className="w-4 h-4 text-purple-600 mr-2" />
                      Right to access personal data
                    </li>
                    <li className="flex items-center">
                      <Eye className="w-4 h-4 text-purple-600 mr-2" />
                      Right to rectification and correction
                    </li>
                    <li className="flex items-center">
                      <Eye className="w-4 h-4 text-purple-600 mr-2" />
                      Right to erasure ("right to be forgotten")
                    </li>
                    <li className="flex items-center">
                      <Eye className="w-4 h-4 text-purple-600 mr-2" />
                      Right to data portability
                    </li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Shield className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Data Security Measures</h2>
              </div>
              <div className="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Technical Safeguards</h3>
                <div className="grid md:grid-cols-3 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Encryption</h4>
                    <ul className="space-y-1 text-gray-700 text-xs">
                      <li>• AES-256 data encryption</li>
                      <li>• TLS 1.3 for data transmission</li>
                      <li>• End-to-end encrypted communications</li>
                      <li>• Encrypted database storage</li>
                      <li>• Secure key management</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Access Controls</h4>
                    <ul className="space-y-1 text-gray-700 text-xs">
                      <li>• Multi-factor authentication</li>
                      <li>• Role-based access permissions</li>
                      <li>• Regular access reviews</li>
                      <li>• Automated session timeouts</li>
                      <li>• Audit trail logging</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Infrastructure</h4>
                    <ul className="space-y-1 text-gray-700 text-xs">
                      <li>• ISO 27001 certified data centers</li>
                      <li>• Regular security assessments</li>
                      <li>• Intrusion detection systems</li>
                      <li>• Automated backup procedures</li>
                      <li>• Disaster recovery planning</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Globe className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">International Data Transfers</h2>
              </div>
              <div className="bg-yellow-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-3">Cross-Border Data Protection</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Transfer Mechanisms</h4>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Standard Contractual Clauses (SCCs)</li>
                      <li>• Adequacy decisions compliance</li>
                      <li>• Binding Corporate Rules (BCRs)</li>
                      <li>• Explicit consent for transfers</li>
                      <li>• Derogations for specific situations</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Data Localization</h4>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Primary data storage in Indonesia</li>
                      <li>• EU data processing compliance</li>
                      <li>• Regional backup facilities</li>
                      <li>• Local data residency options</li>
                      <li>• Cross-border impact assessments</li>
                    </ul>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-yellow-100 rounded-lg">
                  <p className="text-yellow-800 text-sm">
                    <strong>Note:</strong> All international data transfers are conducted in accordance with 
                    GDPR Article 44-49 and Indonesian data protection regulations.
                  </p>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <FileText className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Data Processing Records</h2>
              </div>
              <div className="bg-gray-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Processing Activities Register</h3>
                <div className="space-y-4">
                  {[
                    {
                      activity: 'Client Relationship Management',
                      purpose: 'Service delivery and client communication',
                      categories: 'Contact details, project preferences',
                      retention: '7 years post-project completion',
                      recipients: 'Internal team, authorized contractors'
                    },
                    {
                      activity: 'Marketing Communications',
                      purpose: 'Newsletter and promotional content',
                      categories: 'Email addresses, communication preferences',
                      retention: 'Until consent withdrawal',
                      recipients: 'Marketing team, email service providers'
                    },
                    {
                      activity: 'Financial Processing',
                      purpose: 'Payment processing and accounting',
                      categories: 'Billing information, payment records',
                      retention: '10 years (legal requirement)',
                      recipients: 'Accounting team, payment processors'
                    }
                  ].map((record, index) => (
                    <div key={index} className="bg-white p-4 rounded border">
                      <h4 className="font-medium text-gray-900 mb-2">{record.activity}</h4>
                      <div className="grid md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                          <p><strong>Purpose:</strong> {record.purpose}</p>
                          <p><strong>Data Categories:</strong> {record.categories}</p>
                        </div>
                        <div>
                          <p><strong>Retention Period:</strong> {record.retention}</p>
                          <p><strong>Recipients:</strong> {record.recipients}</p>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <AlertTriangle className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Data Breach Response</h2>
              </div>
              <div className="bg-red-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Incident Response Procedure</h3>
                <div className="space-y-4">
                  {[
                    {
                      phase: 'Detection & Assessment',
                      timeframe: 'Within 1 hour',
                      actions: ['Identify breach scope', 'Assess risk level', 'Contain incident', 'Document findings'],
                      color: 'red'
                    },
                    {
                      phase: 'Notification & Reporting',
                      timeframe: 'Within 72 hours',
                      actions: ['Notify supervisory authority', 'Inform affected individuals', 'Report to management', 'Legal consultation'],
                      color: 'orange'
                    },
                    {
                      phase: 'Remediation & Recovery',
                      timeframe: 'Ongoing',
                      actions: ['Implement fixes', 'Monitor systems', 'Update procedures', 'Conduct review'],
                      color: 'green'
                    }
                  ].map((phase, index) => (
                    <div key={index} className={`bg-${phase.color}-100 p-4 rounded-lg border border-${phase.color}-200`}>
                      <div className="flex justify-between items-start mb-2">
                        <h4 className="font-medium text-gray-900">{phase.phase}</h4>
                        <span className={`text-xs text-${phase.color}-700 bg-${phase.color}-200 px-2 py-1 rounded`}>
                          {phase.timeframe}
                        </span>
                      </div>
                      <div className="grid grid-cols-2 gap-2">
                        {phase.actions.map((action, i) => (
                          <span key={i} className="text-xs text-gray-700 bg-white px-2 py-1 rounded">
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
                <UserCheck className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Consent Management</h2>
              </div>
              <div className="bg-green-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Consent Requirements</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <UserCheck className="w-4 h-4 text-green-600 mr-2" />
                        Freely given and specific consent
                      </li>
                      <li className="flex items-center">
                        <UserCheck className="w-4 h-4 text-green-600 mr-2" />
                        Informed and unambiguous consent
                      </li>
                      <li className="flex items-center">
                        <UserCheck className="w-4 h-4 text-green-600 mr-2" />
                        Granular consent options
                      </li>
                      <li className="flex items-center">
                        <UserCheck className="w-4 h-4 text-green-600 mr-2" />
                        Easy withdrawal mechanisms
                      </li>
                      <li className="flex items-center">
                        <UserCheck className="w-4 h-4 text-green-600 mr-2" />
                        Consent record maintenance
                      </li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Consent Categories</h3>
                    <div className="space-y-3">
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900 text-sm">Essential Services</h4>
                        <p className="text-gray-600 text-xs">Required for service delivery</p>
                      </div>
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900 text-sm">Marketing Communications</h4>
                        <p className="text-gray-600 text-xs">Optional newsletter and updates</p>
                      </div>
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900 text-sm">Analytics & Improvement</h4>
                        <p className="text-gray-600 text-xs">Service enhancement purposes</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Database className="w-6 h-6 text-blue-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Data Retention & Deletion</h2>
              </div>
              <div className="bg-indigo-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Retention Schedule</h3>
                <div className="space-y-3">
                  {[
                    { type: 'Client Project Data', period: '7 years', reason: 'Professional liability and warranty' },
                    { type: 'Financial Records', period: '10 years', reason: 'Legal and tax requirements' },
                    { type: 'Marketing Consents', period: 'Until withdrawal', reason: 'Active consent basis' },
                    { type: 'Communication Logs', period: '3 years', reason: 'Quality assurance and training' },
                    { type: 'Website Analytics', period: '26 months', reason: 'Business intelligence and improvement' }
                  ].map((item, index) => (
                    <div key={index} className="bg-white p-4 rounded border flex justify-between items-center">
                      <div>
                        <h4 className="font-medium text-gray-900">{item.type}</h4>
                        <p className="text-gray-600 text-sm">{item.reason}</p>
                      </div>
                      <span className="text-sm font-medium text-indigo-600 bg-indigo-100 px-3 py-1 rounded">
                        {item.period}
                      </span>
                    </div>
                  ))}
                </div>
                <div className="mt-4 p-4 bg-indigo-100 rounded-lg">
                  <p className="text-indigo-800 text-sm">
                    <strong>Automated Deletion:</strong> Our systems automatically delete data according to 
                    retention schedules unless legal holds or ongoing investigations require extended retention.
                  </p>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Data Protection Contact</h2>
              <div className="bg-blue-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  For data protection inquiries, privacy rights requests, or GDPR compliance questions.
                </p>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Data Protection Officer</h3>
                    <div className="space-y-1 text-gray-700 text-sm">
                      <p><strong>Name:</strong> Cari Prop Shop</p>
                      <p><strong>Email:</strong> dpo@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                      <p><strong>Response Time:</strong> 30 days maximum</p>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Available Services</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Data subject rights requests</li>
                      <li>• Privacy impact assessments</li>
                      <li>• Consent management assistance</li>
                      <li>• Data breach notifications</li>
                    </ul>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-blue-100 rounded-lg">
                  <p className="text-blue-800 text-sm">
                    <strong>Supervisory Authority:</strong> You have the right to lodge a complaint with the 
                    Indonesian Data Protection Authority or your local supervisory authority if you believe 
                    your data protection rights have been violated.
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

export default DataProtection;
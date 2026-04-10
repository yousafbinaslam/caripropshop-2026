import React from 'react';
import { motion } from 'framer-motion';
import { Shield, FileText, AlertTriangle, CheckCircle, DollarSign, Phone } from 'lucide-react';

const InsuranceLiability: React.FC = () => {
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
            <Shield className="w-16 h-16 text-amber-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Insurance & Liability</h1>
            <p className="text-gray-600">Comprehensive coverage and protection for all interior design projects</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Shield className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Professional Insurance Coverage</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-blue-50 p-6 rounded-lg border border-blue-200">
                  <h3 className="font-semibold text-gray-900 mb-3">Professional Liability Insurance</h3>
                  <div className="space-y-2 text-gray-700 text-sm">
                    <p><strong>Coverage Amount:</strong> $2,000,000 per claim</p>
                    <p><strong>Aggregate Limit:</strong> $4,000,000 annually</p>
                    <p><strong>Provider:</strong> AXA Insurance Indonesia</p>
                    <p><strong>Policy Number:</strong> PLI-2024-CPS-001</p>
                  </div>
                  <div className="mt-4">
                    <h4 className="font-medium text-gray-900 mb-2">Coverage Includes:</h4>
                    <ul className="space-y-1 text-gray-700 text-xs">
                      <li>• Design errors and omissions</li>
                      <li>• Professional negligence claims</li>
                      <li>• Copyright infringement</li>
                      <li>• Breach of professional duty</li>
                      <li>• Legal defense costs</li>
                    </ul>
                  </div>
                </div>
                <div className="bg-green-50 p-6 rounded-lg border border-green-200">
                  <h3 className="font-semibold text-gray-900 mb-3">General Liability Insurance</h3>
                  <div className="space-y-2 text-gray-700 text-sm">
                    <p><strong>Coverage Amount:</strong> $1,000,000 per occurrence</p>
                    <p><strong>Aggregate Limit:</strong> $2,000,000 annually</p>
                    <p><strong>Provider:</strong> Allianz Indonesia</p>
                    <p><strong>Policy Number:</strong> GLI-2024-CPS-002</p>
                  </div>
                  <div className="mt-4">
                    <h4 className="font-medium text-gray-900 mb-2">Coverage Includes:</h4>
                    <ul className="space-y-1 text-gray-700 text-xs">
                      <li>• Bodily injury liability</li>
                      <li>• Property damage liability</li>
                      <li>• Personal injury claims</li>
                      <li>• Product liability</li>
                      <li>• Premises liability</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <FileText className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Additional Coverage & Protection</h2>
              </div>
              <div className="space-y-4">
                <div className="bg-purple-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Cyber Liability Insurance</h3>
                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <p className="text-gray-700 text-sm mb-2">
                        <strong>Coverage:</strong> $500,000 per incident
                      </p>
                      <ul className="space-y-1 text-gray-700 text-xs">
                        <li>• Data breach response</li>
                        <li>• Client notification costs</li>
                        <li>• Credit monitoring services</li>
                        <li>• Regulatory fines and penalties</li>
                      </ul>
                    </div>
                    <div>
                      <p className="text-gray-700 text-sm mb-2">
                        <strong>Provider:</strong> Zurich Insurance Indonesia
                      </p>
                      <ul className="space-y-1 text-gray-700 text-xs">
                        <li>• Business interruption coverage</li>
                        <li>• Cyber extortion protection</li>
                        <li>• System restoration costs</li>
                        <li>• Legal defense expenses</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div className="bg-orange-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Equipment & Property Insurance</h3>
                  <div className="grid md:grid-cols-3 gap-4">
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Office Equipment</h4>
                      <ul className="space-y-1 text-gray-700 text-xs">
                        <li>• Computer hardware</li>
                        <li>• Design software licenses</li>
                        <li>• Furniture and fixtures</li>
                        <li>• Professional tools</li>
                      </ul>
                    </div>
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Project Materials</h4>
                      <ul className="space-y-1 text-gray-700 text-xs">
                        <li>• Materials in transit</li>
                        <li>• Stored inventory</li>
                        <li>• Custom fabrications</li>
                        <li>• Client property</li>
                      </ul>
                    </div>
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Business Interruption</h4>
                      <ul className="space-y-1 text-gray-700 text-xs">
                        <li>• Lost income coverage</li>
                        <li>• Extra expense reimbursement</li>
                        <li>• Temporary relocation costs</li>
                        <li>• Client contract penalties</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <AlertTriangle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Liability Limitations & Risk Management</h2>
              </div>
              <div className="bg-red-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Contractual Liability Limits</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Design Services</h4>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Liability limited to project fee amount</li>
                      <li>• Maximum exposure: $500,000 per project</li>
                      <li>• Excludes consequential damages</li>
                      <li>• 2-year statute of limitations</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Excluded Liabilities</h4>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Third-party contractor performance</li>
                      <li>• Material defects and warranties</li>
                      <li>• Building code changes post-design</li>
                      <li>• Client-requested modifications</li>
                    </ul>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-red-100 rounded-lg">
                  <p className="text-red-800 text-sm">
                    <strong>Important:</strong> All liability limitations are subject to applicable Indonesian law 
                    and may not apply in cases of gross negligence or willful misconduct.
                  </p>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Risk Assessment & Prevention</h2>
              </div>
              <div className="bg-green-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Pre-Project Risk Assessment</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Site condition evaluation</li>
                      <li>• Structural integrity assessment</li>
                      <li>• Environmental hazard identification</li>
                      <li>• Client financial verification</li>
                      <li>• Regulatory compliance review</li>
                      <li>• Insurance coverage verification</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Ongoing Risk Management</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Regular safety inspections</li>
                      <li>• Quality control checkpoints</li>
                      <li>• Documentation and record keeping</li>
                      <li>• Client communication protocols</li>
                      <li>• Vendor performance monitoring</li>
                      <li>• Insurance claim procedures</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <DollarSign className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Claims Process & Support</h2>
              </div>
              <div className="bg-indigo-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Insurance Claim Procedure</h3>
                <div className="space-y-4">
                  {[
                    {
                      step: 'Immediate Notification',
                      timeframe: 'Within 24 hours',
                      description: 'Report incident to insurance provider and Cari Prop Shop',
                      actions: ['Document incident details', 'Preserve evidence', 'Notify all parties']
                    },
                    {
                      step: 'Claim Investigation',
                      timeframe: '5-10 business days',
                      description: 'Insurance adjuster reviews claim and evidence',
                      actions: ['Provide documentation', 'Cooperate with investigation', 'Legal consultation if needed']
                    },
                    {
                      step: 'Resolution & Payment',
                      timeframe: '15-30 business days',
                      description: 'Claim settlement and payment processing',
                      actions: ['Review settlement offer', 'Negotiate if necessary', 'Accept payment terms']
                    }
                  ].map((step, index) => (
                    <div key={index} className="bg-white p-4 rounded-lg border">
                      <div className="flex justify-between items-start mb-2">
                        <h4 className="font-medium text-gray-900">{step.step}</h4>
                        <span className="text-xs text-indigo-600 bg-indigo-100 px-2 py-1 rounded">
                          {step.timeframe}
                        </span>
                      </div>
                      <p className="text-gray-700 text-sm mb-2">{step.description}</p>
                      <div className="flex flex-wrap gap-2">
                        {step.actions.map((action, i) => (
                          <span key={i} className="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">
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
                <FileText className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Client Protection & Guarantees</h2>
              </div>
              <div className="bg-yellow-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-3 gap-4">
                  <div className="bg-white p-4 rounded border text-center">
                    <Shield className="w-8 h-8 text-yellow-600 mx-auto mb-2" />
                    <h3 className="font-semibold text-gray-900 mb-2">Design Protection</h3>
                    <p className="text-gray-700 text-sm">90-day design revision guarantee</p>
                  </div>
                  <div className="bg-white p-4 rounded border text-center">
                    <DollarSign className="w-8 h-8 text-green-600 mx-auto mb-2" />
                    <h3 className="font-semibold text-gray-900 mb-2">Financial Security</h3>
                    <p className="text-gray-700 text-sm">Bonded and insured projects</p>
                  </div>
                  <div className="bg-white p-4 rounded border text-center">
                    <CheckCircle className="w-8 h-8 text-blue-600 mx-auto mb-2" />
                    <h3 className="font-semibold text-gray-900 mb-2">Quality Assurance</h3>
                    <p className="text-gray-700 text-sm">Professional standards compliance</p>
                  </div>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Insurance & Claims Contact</h2>
              <div className="bg-amber-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  For insurance-related questions, claims, or certificate requests, please contact our insurance department.
                </p>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Insurance Coordinator</h3>
                    <div className="space-y-1 text-gray-700 text-sm">
                      <p><strong>Name:</strong> Cari Prop Shop</p>
                      <p><strong>Email:</strong> insurance@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                      <p><strong>Emergency:</strong> 24/7 claims hotline</p>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Available Services</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Insurance certificate requests</li>
                      <li>• Claims assistance and filing</li>
                      <li>• Coverage verification</li>
                      <li>• Risk assessment consultation</li>
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

export default InsuranceLiability;
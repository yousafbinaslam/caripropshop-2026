import React from 'react';
import { motion } from 'framer-motion';
import { CheckCircle, Award, Target, Users, Clock, Star, BarChart, Shield } from 'lucide-react';

const QualityAssuranceStandards: React.FC = () => {
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
            <Award className="w-16 h-16 text-amber-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Quality Assurance Standards</h1>
            <p className="text-gray-600">Comprehensive quality control and excellence standards</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Target className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Quality Management System</h2>
              </div>
              <div className="bg-blue-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">ISO 9001:2015 Compliance Framework</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Quality Principles</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Customer focus and satisfaction</li>
                      <li>• Leadership and strategic direction</li>
                      <li>• Engagement of people at all levels</li>
                      <li>• Process approach to management</li>
                      <li>• Continuous improvement culture</li>
                      <li>• Evidence-based decision making</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Quality Objectives</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• 98% client satisfaction rating</li>
                      <li>• 95% on-time project delivery</li>
                      <li>• Zero defects in final deliverables</li>
                      <li>• 100% compliance with design standards</li>
                      <li>• Continuous professional development</li>
                      <li>• Sustainable design practices</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Design Quality Control Process</h2>
              </div>
              <div className="space-y-4">
                {[
                  {
                    phase: 'Initial Design Review',
                    criteria: 'Concept validation and client alignment',
                    checkpoints: ['Design brief compliance', 'Budget feasibility', 'Timeline accuracy', 'Code compliance'],
                    responsible: 'Senior Designer',
                    color: 'blue'
                  },
                  {
                    phase: 'Technical Design Review',
                    criteria: 'Technical accuracy and constructability',
                    checkpoints: ['Structural integrity', 'MEP coordination', 'Material specifications', 'Safety compliance'],
                    responsible: 'Technical Director',
                    color: 'green'
                  },
                  {
                    phase: 'Final Quality Audit',
                    criteria: 'Complete deliverable verification',
                    checkpoints: ['Documentation completeness', 'Drawing accuracy', 'Specification clarity', 'Client approval'],
                    responsible: 'Quality Manager',
                    color: 'purple'
                  }
                ].map((phase, index) => (
                  <div key={index} className={`bg-${phase.color}-50 p-6 rounded-lg border border-${phase.color}-200`}>
                    <div className="flex justify-between items-start mb-3">
                      <h3 className="font-semibold text-gray-900">{phase.phase}</h3>
                      <span className={`px-3 py-1 bg-${phase.color}-100 text-${phase.color}-800 text-sm rounded-full`}>
                        {phase.responsible}
                      </span>
                    </div>
                    <p className="text-gray-700 text-sm mb-3">{phase.criteria}</p>
                    <div className="grid md:grid-cols-2 gap-4">
                      {phase.checkpoints.map((checkpoint, i) => (
                        <div key={i} className="flex items-center">
                          <CheckCircle className={`w-4 h-4 text-${phase.color}-600 mr-2`} />
                          <span className="text-gray-700 text-sm">{checkpoint}</span>
                        </div>
                      ))}
                    </div>
                  </div>
                ))}
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <BarChart className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Performance Metrics & KPIs</h2>
              </div>
              <div className="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Quality Performance Dashboard</h3>
                <div className="grid md:grid-cols-4 gap-6">
                  {[
                    { metric: 'Client Satisfaction', current: '99.2%', target: '98%', trend: 'up', color: 'green' },
                    { metric: 'On-Time Delivery', current: '96.8%', target: '95%', trend: 'up', color: 'blue' },
                    { metric: 'Budget Accuracy', current: '94.5%', target: '90%', trend: 'up', color: 'purple' },
                    { metric: 'Defect Rate', current: '0.3%', target: '<1%', trend: 'down', color: 'orange' }
                  ].map((kpi, index) => (
                    <div key={index} className={`bg-${kpi.color}-50 p-4 rounded-lg text-center border border-${kpi.color}-200`}>
                      <h4 className="font-medium text-gray-900 text-sm mb-2">{kpi.metric}</h4>
                      <div className={`text-2xl font-bold text-${kpi.color}-600 mb-1`}>{kpi.current}</div>
                      <div className="text-xs text-gray-600">Target: {kpi.target}</div>
                      <div className={`text-xs mt-1 ${kpi.trend === 'up' ? 'text-green-600' : 'text-red-600'}`}>
                        {kpi.trend === 'up' ? '↗ Exceeding' : '↘ Improving'}
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Users className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Team Competency & Training</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-indigo-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Professional Development Program</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li className="flex items-center">
                      <Star className="w-4 h-4 text-indigo-600 mr-2" />
                      40 hours annual continuing education
                    </li>
                    <li className="flex items-center">
                      <Star className="w-4 h-4 text-indigo-600 mr-2" />
                      Industry certification maintenance
                    </li>
                    <li className="flex items-center">
                      <Star className="w-4 h-4 text-indigo-600 mr-2" />
                      Software proficiency updates
                    </li>
                    <li className="flex items-center">
                      <Star className="w-4 h-4 text-indigo-600 mr-2" />
                      Quality management training
                    </li>
                    <li className="flex items-center">
                      <Star className="w-4 h-4 text-indigo-600 mr-2" />
                      Client service excellence
                    </li>
                  </ul>
                </div>
                <div className="bg-orange-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Competency Assessment</h3>
                  <div className="space-y-3">
                    {[
                      { skill: 'Design Expertise', level: 95, color: 'orange' },
                      { skill: 'Technical Knowledge', level: 92, color: 'blue' },
                      { skill: 'Client Communication', level: 98, color: 'green' },
                      { skill: 'Project Management', level: 90, color: 'purple' }
                    ].map((skill, index) => (
                      <div key={index}>
                        <div className="flex justify-between items-center mb-1">
                          <span className="text-sm font-medium text-gray-900">{skill.skill}</span>
                          <span className="text-sm text-gray-600">{skill.level}%</span>
                        </div>
                        <div className="w-full bg-gray-200 rounded-full h-2">
                          <div 
                            className={`bg-${skill.color}-500 h-2 rounded-full`} 
                            style={{width: `${skill.level}%`}}
                          />
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Clock className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Quality Monitoring & Improvement</h2>
              </div>
              <div className="bg-yellow-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Continuous Improvement Process</h3>
                <div className="grid md:grid-cols-3 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Monthly Reviews</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Project quality assessments</li>
                      <li>• Client feedback analysis</li>
                      <li>• Process efficiency reviews</li>
                      <li>• Team performance evaluations</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Quarterly Audits</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Quality system compliance</li>
                      <li>• Documentation reviews</li>
                      <li>• Training effectiveness</li>
                      <li>• Corrective action tracking</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Annual Assessments</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Strategic quality planning</li>
                      <li>• Certification renewals</li>
                      <li>• Benchmark comparisons</li>
                      <li>• Investment in improvements</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Shield className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Quality Assurance Certifications</h2>
              </div>
              <div className="bg-gradient-to-r from-purple-50 to-indigo-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Current Certifications</h3>
                    <div className="space-y-3">
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900">ISO 9001:2015</h4>
                        <p className="text-gray-600 text-sm">Quality Management Systems</p>
                        <p className="text-gray-500 text-xs">Valid until: December 2025</p>
                      </div>
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900">IAI Professional Certification</h4>
                        <p className="text-gray-600 text-sm">Indonesian Interior Architects</p>
                        <p className="text-gray-500 text-xs">Annual renewal required</p>
                      </div>
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900">LEED AP Certification</h4>
                        <p className="text-gray-600 text-sm">Green Building Specialist</p>
                        <p className="text-gray-500 text-xs">Continuing education maintained</p>
                      </div>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Quality Commitments</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        100% design review completion
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Client satisfaction guarantee
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Professional liability coverage
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Continuous improvement culture
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Industry best practices adherence
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Quality Assurance Contact</h2>
              <div className="bg-amber-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  For quality-related inquiries, feedback, or to report quality concerns.
                </p>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Quality Manager</h3>
                    <div className="space-y-1 text-gray-700 text-sm">
                      <p><strong>Name:</strong> Cari Prop Shop</p>
                      <p><strong>Email:</strong> quality@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                      <p><strong>Certification:</strong> ISO 9001 Lead Auditor</p>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Quality Services</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Quality system audits</li>
                      <li>• Process improvement consulting</li>
                      <li>• Training and development</li>
                      <li>• Client satisfaction surveys</li>
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

export default QualityAssuranceStandards;
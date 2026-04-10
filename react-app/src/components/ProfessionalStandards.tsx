import React from 'react';
import { motion } from 'framer-motion';
import { Award, Users, CheckCircle, Shield, BookOpen, Star } from 'lucide-react';

const ProfessionalStandards: React.FC = () => {
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
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Professional Standards</h1>
            <p className="text-gray-600">Our commitment to excellence and ethical practice</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Shield className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Code of Ethics</h2>
              </div>
              <div className="bg-blue-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Core Principles</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Client Relations</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Honest and transparent communication</li>
                      <li>• Confidentiality of client information</li>
                      <li>• Fair and reasonable pricing</li>
                      <li>• Timely project delivery</li>
                      <li>• Professional appearance and conduct</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Professional Integrity</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Accurate representation of capabilities</li>
                      <li>• Respect for intellectual property</li>
                      <li>• Compliance with building codes</li>
                      <li>• Sustainable design practices</li>
                      <li>• Continuous professional development</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <BookOpen className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Professional Qualifications</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-green-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Principal Designer</h3>
                  <div className="space-y-2">
                    <div className="flex items-center">
                      <Award className="w-4 h-4 text-green-600 mr-2" />
                      <span className="text-gray-700 text-sm">Certified Interior Designer (CID)</span>
                    </div>
                    <div className="flex items-center">
                      <Award className="w-4 h-4 text-green-600 mr-2" />
                      <span className="text-gray-700 text-sm">Master of Interior Architecture</span>
                    </div>
                    <div className="flex items-center">
                      <Award className="w-4 h-4 text-green-600 mr-2" />
                      <span className="text-gray-700 text-sm">12+ Years Professional Experience</span>
                    </div>
                    <div className="flex items-center">
                      <Award className="w-4 h-4 text-green-600 mr-2" />
                      <span className="text-gray-700 text-sm">Licensed Design Professional</span>
                    </div>
                  </div>
                </div>
                <div className="bg-purple-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Sustainability Director</h3>
                  <div className="space-y-2">
                    <div className="flex items-center">
                      <Award className="w-4 h-4 text-purple-600 mr-2" />
                      <span className="text-gray-700 text-sm">Sustainable Design Specialist</span>
                    </div>
                    <div className="flex items-center">
                      <Award className="w-4 h-4 text-purple-600 mr-2" />
                      <span className="text-gray-700 text-sm">LEED Accredited Professional</span>
                    </div>
                    <div className="flex items-center">
                      <Award className="w-4 h-4 text-purple-600 mr-2" />
                      <span className="text-gray-700 text-sm">8+ Years Design Experience</span>
                    </div>
                    <div className="flex items-center">
                      <Award className="w-4 h-4 text-purple-600 mr-2" />
                      <span className="text-gray-700 text-sm">Environmental Design Certified</span>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Quality Assurance Standards</h2>
              </div>
              <div className="bg-gradient-to-r from-orange-50 to-red-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-3 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Design Process</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Comprehensive client consultation</li>
                      <li>• Detailed site analysis</li>
                      <li>• Multiple design iterations</li>
                      <li>• Client approval at each phase</li>
                      <li>• Regular progress reviews</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Documentation</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Accurate technical drawings</li>
                      <li>• Detailed specifications</li>
                      <li>• Material and finish schedules</li>
                      <li>• Construction documentation</li>
                      <li>• Project timeline tracking</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Implementation</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Vendor quality verification</li>
                      <li>• Installation supervision</li>
                      <li>• Quality control inspections</li>
                      <li>• Client walkthrough</li>
                      <li>• Post-completion support</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Users className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Industry Memberships & Affiliations</h2>
              </div>
              <div className="bg-indigo-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Professional Organizations</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Indonesian Interior Designers Association (IIDA)</li>
                      <li>• International Interior Design Association</li>
                      <li>• Green Building Council Indonesia</li>
                      <li>• Southeast Asian Design Network</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Certifications & Training</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Annual continuing education requirements</li>
                      <li>• Sustainable design workshops</li>
                      <li>• Technology and software training</li>
                      <li>• Safety and building code updates</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Star className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Performance Metrics & Standards</h2>
              </div>
              <div className="grid md:grid-cols-4 gap-4">
                {[
                  { metric: 'Client Satisfaction', target: '98%', current: '99.2%', color: 'green' },
                  { metric: 'On-Time Delivery', target: '95%', current: '96.8%', color: 'blue' },
                  { metric: 'Budget Accuracy', target: '90%', current: '94.5%', color: 'purple' },
                  { metric: 'Quality Score', target: '4.5/5', current: '4.8/5', color: 'orange' }
                ].map((item, index) => (
                  <div key={index} className={`bg-${item.color}-50 p-4 rounded-lg text-center border border-${item.color}-200`}>
                    <h3 className="font-semibold text-gray-900 text-sm mb-2">{item.metric}</h3>
                    <div className={`text-2xl font-bold text-${item.color}-600 mb-1`}>{item.current}</div>
                    <div className="text-xs text-gray-600">Target: {item.target}</div>
                  </div>
                ))}
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Shield className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Compliance & Legal Standards</h2>
              </div>
              <div className="bg-yellow-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Regulatory Compliance</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Indonesian building codes and regulations</li>
                      <li>• Fire safety and accessibility standards</li>
                      <li>• Environmental protection requirements</li>
                      <li>• Professional licensing compliance</li>
                      <li>• Insurance and bonding requirements</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Business Standards</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Transparent pricing and contracts</li>
                      <li>• Data protection and privacy</li>
                      <li>• Anti-discrimination policies</li>
                      <li>• Sustainable business practices</li>
                      <li>• Community engagement initiatives</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Continuous Improvement</h2>
              </div>
              <div className="bg-gradient-to-r from-teal-50 to-cyan-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Our Commitment to Excellence</h3>
                <div className="grid md:grid-cols-3 gap-4">
                  <div className="bg-white p-4 rounded border">
                    <h4 className="font-medium text-gray-900 mb-2">Client Feedback</h4>
                    <p className="text-gray-700 text-sm">Regular surveys and reviews to improve our services</p>
                  </div>
                  <div className="bg-white p-4 rounded border">
                    <h4 className="font-medium text-gray-900 mb-2">Technology Updates</h4>
                    <p className="text-gray-700 text-sm">Latest design software and visualization tools</p>
                  </div>
                  <div className="bg-white p-4 rounded border">
                    <h4 className="font-medium text-gray-900 mb-2">Industry Trends</h4>
                    <p className="text-gray-700 text-sm">Staying current with design trends and innovations</p>
                  </div>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Professional Standards Contact</h2>
              <div className="bg-amber-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  For questions about our professional standards or to report concerns, please contact us:
                </p>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Professional Standards Officer</h3>
                    <div className="space-y-1 text-gray-700 text-sm">
                      <p><strong>Name:</strong> Cari Prop Shop</p>
                      <p><strong>Email:</strong> standards@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Quality Assurance</h3>
                    <div className="space-y-1 text-gray-700 text-sm">
                      <p><strong>Response Time:</strong> 24 hours</p>
                      <p><strong>Review Process:</strong> 5-7 business days</p>
                      <p><strong>Follow-up:</strong> Continuous monitoring</p>
                    </div>
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

export default ProfessionalStandards;
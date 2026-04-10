import React from 'react';
import { motion } from 'framer-motion';
import { Shield, Eye, Lock, Database, UserCheck, AlertTriangle } from 'lucide-react';

const PrivacyPolicy: React.FC = () => {
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
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Privacy Policy</h1>
            <p className="text-gray-600">Last updated: {new Date().toLocaleDateString()}</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Eye className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Information We Collect</h2>
              </div>
              <div className="bg-gray-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-3">Personal Information</h3>
                <ul className="space-y-2 text-gray-700">
                  <li>• Name, email address, and phone number</li>
                  <li>• Project details and design preferences</li>
                  <li>• Property information and measurements</li>
                  <li>• Budget and timeline requirements</li>
                  <li>• Communication history and consultation notes</li>
                </ul>
              </div>
              <div className="bg-gray-50 p-6 rounded-lg mt-4">
                <h3 className="font-semibold text-gray-900 mb-3">Technical Information</h3>
                <ul className="space-y-2 text-gray-700">
                  <li>• IP address and browser information</li>
                  <li>• Website usage patterns and analytics</li>
                  <li>• Device information and screen resolution</li>
                  <li>• Cookies and tracking preferences</li>
                </ul>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Database className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">How We Use Your Information</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-blue-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Service Delivery</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Providing interior design consultations</li>
                    <li>• Creating custom design proposals</li>
                    <li>• Project management and coordination</li>
                    <li>• Client communication and updates</li>
                  </ul>
                </div>
                <div className="bg-green-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Business Operations</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Processing payments and invoicing</li>
                    <li>• Marketing and promotional activities</li>
                    <li>• Website improvement and analytics</li>
                    <li>• Legal compliance and record keeping</li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Lock className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Data Protection & Security</h2>
              </div>
              <div className="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Security Measures</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• SSL encryption for data transmission</li>
                      <li>• Secure cloud storage with backup</li>
                      <li>• Regular security audits and updates</li>
                      <li>• Limited access on need-to-know basis</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Data Retention</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li>• Project files: 7 years after completion</li>
                      <li>• Client communications: 5 years</li>
                      <li>• Financial records: As required by law</li>
                      <li>• Marketing data: Until opt-out request</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <UserCheck className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Your Rights</h2>
              </div>
              <div className="grid md:grid-cols-3 gap-4">
                {[
                  { title: 'Access', desc: 'Request copies of your personal data' },
                  { title: 'Rectification', desc: 'Correct inaccurate information' },
                  { title: 'Erasure', desc: 'Request deletion of your data' },
                  { title: 'Portability', desc: 'Transfer data to another service' },
                  { title: 'Restriction', desc: 'Limit how we process your data' },
                  { title: 'Objection', desc: 'Object to certain data processing' }
                ].map((right, index) => (
                  <div key={index} className="bg-gray-50 p-4 rounded-lg text-center">
                    <h3 className="font-semibold text-gray-900 mb-2">{right.title}</h3>
                    <p className="text-gray-600 text-sm">{right.desc}</p>
                  </div>
                ))}
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <AlertTriangle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Third-Party Services</h2>
              </div>
              <div className="bg-yellow-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  We may use third-party services to enhance our operations. These include:
                </p>
                <div className="grid md:grid-cols-2 gap-4">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Analytics & Marketing</h3>
                    <ul className="text-gray-700 text-sm space-y-1">
                      <li>• Google Analytics for website insights</li>
                      <li>• Email marketing platforms</li>
                      <li>• Social media integration</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Business Operations</h3>
                    <ul className="text-gray-700 text-sm space-y-1">
                      <li>• Payment processing services</li>
                      <li>• Cloud storage providers</li>
                      <li>• Communication platforms</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Contact Information</h2>
              <div className="bg-amber-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  For any privacy-related questions or to exercise your rights, please contact us:
                </p>
                <div className="grid md:grid-cols-2 gap-4">
                  <div>
                    <p className="font-semibold text-gray-900">Data Protection Officer</p>
                    <p className="text-gray-700">Cari Prop Shop</p>
                    <p className="text-gray-700">Email: privacy@caripropshop.com</p>
                    <p className="text-gray-700">Phone: Available upon request</p>
                  </div>
                  <div>
                    <p className="font-semibold text-gray-900">Business Address</p>
                    <p className="text-gray-700">Cari Prop Shop</p>
                    <p className="text-gray-700">Surabaya East, Indonesia</p>
                    <p className="text-gray-700">Response time: 48 hours</p>
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

export default PrivacyPolicy;
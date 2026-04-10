import React from 'react';
import { motion } from 'framer-motion';
import { Copyright, Shield, Eye, FileText, AlertTriangle, Scale } from 'lucide-react';

const CopyrightNotice: React.FC = () => {
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
            <Copyright className="w-16 h-16 text-amber-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Copyright Notice</h1>
            <p className="text-gray-600">Intellectual Property Rights & Usage Terms</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Shield className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Copyright Ownership</h2>
              </div>
              <div className="bg-blue-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  All content, designs, images, text, graphics, logos, and other materials on this website 
                  and in our design services are the exclusive property of Cari Prop Shop and are protected 
                  by Indonesian and international copyright laws.
                </p>
                <div className="grid md:grid-cols-2 gap-4">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Protected Materials Include:</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Original design concepts and drawings</li>
                      <li>• 3D renderings and visualizations</li>
                      <li>• Floor plans and technical drawings</li>
                      <li>• Photography and project images</li>
                      <li>• Written content and descriptions</li>
                      <li>• Company logos and branding</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Copyright Details:</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• © 2024 Cari Prop Shop</li>
                      <li>• All rights reserved worldwide</li>
                      <li>• Protected under Indonesian law</li>
                      <li>• International copyright treaties apply</li>
                      <li>• Unauthorized use prohibited</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Eye className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Permitted Uses</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-green-50 p-6 rounded-lg border border-green-200">
                  <h3 className="font-semibold text-gray-900 mb-3 flex items-center">
                    <FileText className="w-5 h-5 text-green-600 mr-2" />
                    Allowed Uses
                  </h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Personal viewing of website content</li>
                    <li>• Sharing project images with proper attribution</li>
                    <li>• Educational use with written permission</li>
                    <li>• Media coverage with prior approval</li>
                    <li>• Client use of their commissioned designs</li>
                  </ul>
                </div>
                <div className="bg-red-50 p-6 rounded-lg border border-red-200">
                  <h3 className="font-semibold text-gray-900 mb-3 flex items-center">
                    <AlertTriangle className="w-5 h-5 text-red-600 mr-2" />
                    Prohibited Uses
                  </h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li>• Commercial use without license</li>
                    <li>• Reproduction for competing services</li>
                    <li>• Modification or derivative works</li>
                    <li>• Distribution without permission</li>
                    <li>• Removal of copyright notices</li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Scale className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Design Rights & Client Usage</h2>
              </div>
              <div className="bg-gradient-to-r from-purple-50 to-indigo-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Client Design Rights</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Upon Full Payment:</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Right to implement the specific design</li>
                      <li>• Use for the commissioned project only</li>
                      <li>• Modification rights for personal use</li>
                      <li>• Transfer rights with property sale</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Retained Rights:</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Portfolio and marketing usage</li>
                      <li>• Design methodology and concepts</li>
                      <li>• Reproduction for other projects</li>
                      <li>• Educational and promotional use</li>
                    </ul>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-purple-100 rounded-lg">
                  <p className="text-purple-800 text-sm">
                    <strong>Important:</strong> Clients receive usage rights, not ownership of the design copyright. 
                    Original creative concepts remain the intellectual property of Cari Prop Shop.
                  </p>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <AlertTriangle className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Third-Party Content</h2>
              </div>
              <div className="bg-yellow-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-3">Licensed Materials</h3>
                <p className="text-gray-700 mb-4">
                  Some content on our website and in our designs may include licensed materials from third parties. 
                  These materials are used under appropriate licenses and are subject to their respective copyright terms.
                </p>
                <div className="grid md:grid-cols-2 gap-4">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Third-Party Sources:</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Stock photography and images</li>
                      <li>• Furniture and product catalogs</li>
                      <li>• Material and finish libraries</li>
                      <li>• Software templates and assets</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Usage Compliance:</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Proper attribution maintained</li>
                      <li>• License terms strictly followed</li>
                      <li>• Commercial use permissions verified</li>
                      <li>• Regular license renewals</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Shield className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Copyright Infringement</h2>
              </div>
              <div className="bg-red-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-3">Reporting Violations</h3>
                <p className="text-gray-700 mb-4">
                  If you believe your copyrighted work has been used without permission, please contact us immediately 
                  with the following information:
                </p>
                <div className="grid md:grid-cols-2 gap-4">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Required Information:</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Description of copyrighted work</li>
                      <li>• Location of alleged infringement</li>
                      <li>• Proof of copyright ownership</li>
                      <li>• Contact information</li>
                      <li>• Good faith statement</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Our Response:</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Immediate investigation</li>
                      <li>• Content removal if verified</li>
                      <li>• Legal compliance measures</li>
                      <li>• Prevention of future violations</li>
                      <li>• Cooperation with authorities</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <FileText className="w-6 h-6 text-amber-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Licensing & Permissions</h2>
              </div>
              <div className="bg-indigo-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-3">Commercial Licensing</h3>
                <p className="text-gray-700 mb-4">
                  For commercial use of our designs, images, or content, please contact us for licensing arrangements:
                </p>
                <div className="grid md:grid-cols-3 gap-4">
                  <div className="bg-white p-4 rounded border text-center">
                    <h4 className="font-medium text-gray-900 mb-2">Media License</h4>
                    <p className="text-gray-600 text-sm">Press and publication use</p>
                  </div>
                  <div className="bg-white p-4 rounded border text-center">
                    <h4 className="font-medium text-gray-900 mb-2">Commercial License</h4>
                    <p className="text-gray-600 text-sm">Business and marketing use</p>
                  </div>
                  <div className="bg-white p-4 rounded border text-center">
                    <h4 className="font-medium text-gray-900 mb-2">Educational License</h4>
                    <p className="text-gray-600 text-sm">Academic and training use</p>
                  </div>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Contact for Copyright Matters</h2>
              <div className="bg-amber-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Copyright Officer</h3>
                    <div className="space-y-2 text-gray-700 text-sm">
                      <p><strong>Name:</strong> Cari Prop Shop</p>
                      <p><strong>Title:</strong> Copyright Officer</p>
                      <p><strong>Email:</strong> copyright@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Legal Department</h3>
                    <div className="space-y-2 text-gray-700 text-sm">
                      <p><strong>Address:</strong> Surabaya East, Indonesia</p>
                      <p><strong>Business Hours:</strong> Mon-Fri 9AM-6PM</p>
                      <p><strong>Response Time:</strong> 48 hours</p>
                      <p><strong>Legal Counsel:</strong> Available upon request</p>
                    </div>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-amber-100 rounded-lg">
                  <p className="text-amber-800 text-sm">
                    <strong>Notice:</strong> This copyright notice is governed by Indonesian copyright law and 
                    international treaties. Violations may result in legal action and monetary damages.
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

export default CopyrightNotice;
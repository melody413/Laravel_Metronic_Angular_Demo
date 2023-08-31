import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditPharmacyComponent } from './edit-pharmacy.component';

describe('EditPharmacyComponent', () => {
  let component: EditPharmacyComponent;
  let fixture: ComponentFixture<EditPharmacyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditPharmacyComponent]
    });
    fixture = TestBed.createComponent(EditPharmacyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditLabCompanyComponent } from './edit-lab-company.component';

describe('EditLabCompanyComponent', () => {
  let component: EditLabCompanyComponent;
  let fixture: ComponentFixture<EditLabCompanyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditLabCompanyComponent]
    });
    fixture = TestBed.createComponent(EditLabCompanyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
